<?php

namespace Tests\Feature;

use App\Mail\DocumentStatusNotification;
use App\Mail\VacationStatusNotification;
use App\Models\Document;
use App\Models\Evaluation;
use App\Models\Homework;
use App\Models\Material;
use App\Models\User;
use App\Models\Vacation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RequestWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        Storage::fake('local');
    }

    public function test_collaborator_can_request_a_document(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/document-request', [
            'type' => 'work certificate',
            'title' => 'Work certificate',
            'description' => 'For my bank',
            'attached_files' => [UploadedFile::fake()->create('id.pdf', 10)],
        ])->assertRedirect(route('dashboard'));

        $document = Document::sole();
        $this->assertSame('work certificate', $document->type);
        $this->assertSame($user->id, $document->user_id);
        Storage::disk('local')->assertExists('public/documents/' . json_decode($document->attached_files)[0]);
    }

    public function test_document_type_must_be_a_known_value(): void
    {
        $this->actingAs(User::factory()->create())->post('/document-request', [
            'type' => 'anything',
            'title' => 'x',
            'description' => 'x',
        ])->assertSessionHasErrors('type');
    }

    public function test_collaborator_can_request_unpaid_leave_with_an_attachment(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/vacation-request', [
            'title' => 'Family trip',
            'description' => 'Visiting family',
            'from' => now()->addDay()->toDateString(),
            'to' => now()->addDays(3)->toDateString(),
            'attached_file' => UploadedFile::fake()->create('ticket.pdf', 10),
        ])->assertRedirect(route('dashboard'));

        $vacation = Vacation::sole();
        $this->assertFalse((bool) $vacation->paid);
        $this->assertNotNull($vacation->attached_file);
        // The stored file must be the one the record points to
        Storage::disk('local')->assertExists('public/documents/' . $vacation->attached_file);
    }

    public function test_paid_leave_is_recorded_as_paid(): void
    {
        $this->actingAs(User::factory()->create())->post('/vacation-request', [
            'title' => 'Holiday',
            'description' => 'Summer',
            'from' => now()->addDay()->toDateString(),
            'to' => now()->addDays(2)->toDateString(),
            'paid' => 'on',
        ]);

        $this->assertTrue((bool) Vacation::sole()->paid);
    }

    public function test_collaborator_can_request_material_remote_work_and_evaluation(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/material-request', ['title' => 'Laptop', 'specification' => '16GB RAM'])
            ->assertRedirect(route('dashboard'));
        $this->post('/homework-request', ['description' => 'Remote on Fridays', 'is_lifetime' => 'on'])
            ->assertRedirect(route('dashboard'));
        $this->post('/evaluation-request', [
            'title' => 'Yearly review',
            'description' => 'Discuss objectives',
            'day' => now()->addWeek()->toDateString(),
            'time' => '10:30',
        ])->assertRedirect(route('dashboard'));

        $this->assertSame(1, Material::count());
        $this->assertTrue((bool) Homework::sole()->is_lifetime);
        $this->assertSame(1, Evaluation::count());
    }

    public function test_evaluation_requires_a_time(): void
    {
        $this->actingAs(User::factory()->create())->post('/evaluation-request', [
            'title' => 'Review',
            'description' => 'x',
            'day' => now()->addWeek()->toDateString(),
        ])->assertSessionHasErrors('time');
    }

    public function test_admin_accepts_a_request_and_the_collaborator_is_emailed(): void
    {
        $collaborator = User::factory()->create();
        $document = Document::create([
            'title' => 'Payslip', 'description' => 'x', 'type' => 'payroll statement', 'user_id' => $collaborator->id,
        ]);

        $this->actingAs(User::factory()->admin()->create())
            ->patch(route('document-management.accept', $document->id))
            ->assertRedirect(route('document-management.index'));

        $this->assertSame(1, $document->fresh()->status);
        Mail::assertSent(DocumentStatusNotification::class, fn ($mail) => $mail->hasTo($collaborator->email));
    }

    public function test_admin_rejects_a_vacation(): void
    {
        $vacation = Vacation::create([
            'title' => 'Leave', 'description' => 'x', 'from' => now()->toDateString(), 'paid' => false,
            'user_id' => User::factory()->create()->id,
        ]);

        $this->actingAs(User::factory()->admin()->create())
            ->patch(route('vacation-management.reject', $vacation->id));

        $this->assertSame(2, $vacation->fresh()->status);
        Mail::assertSent(VacationStatusNotification::class);
    }

    public function test_decisions_cannot_be_made_with_a_plain_link(): void
    {
        $document = Document::create([
            'title' => 'Payslip', 'description' => 'x', 'type' => 'payroll statement',
            'user_id' => User::factory()->create()->id,
        ]);

        $this->actingAs(User::factory()->admin()->create())
            ->get("/document-management/{$document->id}/accept")
            ->assertStatus(405);

        $this->assertSame(0, $document->fresh()->status);
    }

    public function test_collaborators_cannot_reach_admin_pages(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('document-management.index'))
            ->assertForbidden();
    }

    public function test_guests_are_sent_to_login_from_admin_pages(): void
    {
        $this->get(route('user-management.index'))->assertRedirect(route('login'));
    }

    public function test_admin_dashboards_and_lists_render(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        foreach (['dashboard', 'admin-history', 'document-management.index', 'material-management.index',
            'vacation-management.index', 'homework-management.index', 'evaluation-management.index',
            'user-management.index', 'user-management.create'] as $route) {
            $this->get(route($route))->assertOk();
        }
    }

    public function test_collaborator_pages_render(): void
    {
        $this->actingAs(User::factory()->create());

        foreach (['dashboard', 'collaborator-history', 'document-request.create', 'material-request.create',
            'vacation-request.create', 'homework-request.create', 'evaluation-request.create', 'profile.edit'] as $route) {
            $this->get(route($route))->assertOk();
        }
    }

    public function test_admin_can_change_a_collaborator_role(): void
    {
        $collaborator = User::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->patch(route('user-management.update', $collaborator->id), ['role' => 'admin']);

        $this->assertSame('admin', $collaborator->fresh()->role);
    }

    public function test_admin_cannot_grant_super_admin(): void
    {
        $collaborator = User::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->patch(route('user-management.update', $collaborator->id), ['role' => 'super-admin'])
            ->assertSessionHasErrors('role');

        $this->assertSame('collaborator', $collaborator->fresh()->role);
    }

    public function test_admin_cannot_demote_or_delete_the_super_admin(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();
        $this->actingAs(User::factory()->admin()->create());

        $this->patch(route('user-management.update', $superAdmin->id), ['role' => 'collaborator'])->assertForbidden();
        $this->delete(route('user-management.destroy', $superAdmin->id))->assertForbidden();

        $this->assertSame('super-admin', $superAdmin->fresh()->role);
        $this->assertNotSoftDeleted($superAdmin);
    }

    public function test_dashboard_shows_recent_decisions_but_not_old_ones(): void
    {
        $user = User::factory()->create();
        $recent = Material::create(['title' => 'Recent mouse', 'specification' => 'x', 'user_id' => $user->id, 'status' => 1]);
        $old = Material::create(['title' => 'Old keyboard', 'specification' => 'x', 'user_id' => $user->id, 'status' => 1]);
        $old->timestamps = false;
        $old->forceFill(['updated_at' => now()->subMonth()])->save();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $pending = $response->viewData('materialPendings');
        $this->assertTrue($pending->contains($recent));
        $this->assertFalse($pending->contains($old));
    }
}
