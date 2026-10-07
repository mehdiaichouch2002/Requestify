<?php

namespace Tests\Feature;

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

/**
 * Every create / read / decide / delete path, plus the edge cases found
 * while auditing them (deleted users, repeated decisions, uploads).
 */
class CrudAuditTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $collaborator;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        Storage::fake('local');
        $this->admin = User::factory()->admin()->create();
        $this->collaborator = User::factory()->create();
    }

    /** One pending request of each type, owned by the collaborator. */
    private function requests(): array
    {
        $id = $this->collaborator->id;

        return [
            'document-management' => Document::create(['title' => 'Payslip', 'description' => 'x', 'type' => 'payroll statement', 'user_id' => $id]),
            'material-management' => Material::create(['title' => 'Monitor', 'specification' => '27"', 'user_id' => $id]),
            'vacation-management' => Vacation::create(['title' => 'Leave', 'description' => 'x', 'from' => now()->toDateString(), 'to' => now()->addDay()->toDateString(), 'paid' => true, 'user_id' => $id]),
            'homework-management' => Homework::create(['description' => 'Fridays', 'is_lifetime' => true, 'user_id' => $id]),
            'evaluation-management' => Evaluation::create(['title' => 'Review', 'description' => 'x', 'day' => now()->addWeek()->toDateString(), 'time' => '10:30', 'user_id' => $id]),
        ];
    }

    public function test_every_show_page_renders(): void
    {
        $this->actingAs($this->admin);
        foreach ($this->requests() as $prefix => $model) {
            $this->get(route("$prefix.show", $model->id))->assertOk();
        }
    }

    public function test_every_request_can_be_accepted_rejected_and_deleted(): void
    {
        $this->actingAs($this->admin);
        $requests = $this->requests();

        foreach ($requests as $prefix => $model) {
            $this->patch(route("$prefix.accept", $model->id))->assertRedirect(route("$prefix.index"));
            $this->assertSame(1, $model->fresh()->status, $prefix);
        }
        foreach ($this->requests() as $prefix => $model) {
            $this->patch(route("$prefix.reject", $model->id))->assertRedirect(route("$prefix.index"));
            $this->assertSame(2, $model->fresh()->status, $prefix);
        }
        foreach ($requests as $prefix => $model) {
            $this->delete(route("$prefix.destroy", $model->id))->assertRedirect(route("$prefix.index"));
            $this->assertNull($model->fresh(), $prefix);
        }
    }

    public function test_a_decision_cannot_be_changed_afterwards(): void
    {
        $this->actingAs($this->admin);
        foreach ($this->requests() as $prefix => $model) {
            $this->patch(route("$prefix.accept", $model->id));
            $this->patch(route("$prefix.reject", $model->id))->assertSessionHasErrors('status');
            $this->assertSame(1, $model->fresh()->status, $prefix);
        }
        Mail::assertSentCount(5);
    }

    public function test_a_concurrent_second_decision_is_refused(): void
    {
        $document = $this->requests()['document-management'];
        $staleCopy = $document->fresh(); // read by a second request before the first one saved

        $this->actingAs($this->admin)->patch(route('document-management.accept', $document->id));

        $decider = new class {
            use \App\Http\Controllers\Concerns\DecidesRequests;

            public function run($request, int $status)
            {
                return $this->decide($request, $status, \App\Mail\DocumentStatusNotification::class, 'document-management.index', 'x');
            }
        };
        $this->assertTrue($decider->run($staleCopy, 2)->getSession()->get('errors')->has('status'));

        $this->assertSame(1, $document->fresh()->status);
        Mail::assertSentCount(1);
    }

    public function test_pages_still_work_after_the_requester_is_deleted(): void
    {
        $requests = $this->requests();
        $this->collaborator->delete(); // soft delete, as user management does

        $this->actingAs($this->admin);
        foreach (['dashboard', 'admin-history', 'document-management.index', 'material-management.index',
            'vacation-management.index', 'homework-management.index', 'evaluation-management.index'] as $route) {
            $this->get(route($route))->assertOk();
        }
        foreach ($requests as $prefix => $model) {
            $this->get(route("$prefix.show", $model->id))->assertOk();
            $this->patch(route("$prefix.accept", $model->id))->assertRedirect();
        }
    }

    public function test_a_failing_mail_server_does_not_break_the_decision(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP down'));
        $document = $this->requests()['document-management'];

        $this->actingAs($this->admin)
            ->patch(route('document-management.accept', $document->id))
            ->assertRedirect(route('document-management.index'));

        $this->assertSame(1, $document->fresh()->status);
    }

    public function test_non_numeric_ids_are_not_found(): void
    {
        $this->actingAs($this->admin)->get('/material-management/abc/show')->assertNotFound();
    }

    public function test_uploads_named_php_are_refused_and_never_stored(): void
    {
        $file = UploadedFile::fake()->createWithContent('payslip.php', "%PDF-1.4
%fake pdf
");

        foreach ([
            ['/document-request', ['type' => 'payroll statement', 'title' => 'x', 'description' => 'x', 'attached_files' => [$file]], 'attached_files.0'],
            ['/material-request', ['title' => 'x', 'specification' => 'x', 'attached_file' => $file], 'attached_file'],
            ['/vacation-request', ['title' => 'x', 'description' => 'x', 'from' => now()->addDay()->toDateString(), 'to' => now()->addDays(2)->toDateString(), 'attached_file' => $file], 'attached_file'],
        ] as [$url, $data, $field]) {
            $this->actingAs($this->collaborator)->post($url, $data)->assertSessionHasErrors($field);
        }

        $this->assertSame([], Storage::disk('local')->allFiles('public/documents'));
    }

    public function test_stored_attachments_use_the_extension_of_their_content(): void
    {
        $this->actingAs($this->collaborator)->post('/material-request', [
            'title' => 'Laptop', 'specification' => 'x', 'attached_file' => UploadedFile::fake()->image('Quote From Supplier.PNG'),
        ]);

        $name = Material::sole()->attached_file;
        $this->assertMatchesRegularExpression('/^quote-from-supplier_\d+_[a-z0-9]{6}\.png$/', $name);
        Storage::disk('local')->assertExists('public/documents/' . $name);
    }

    public function test_material_attachments_are_limited_to_documents_and_images(): void
    {
        $this->actingAs($this->collaborator)->post('/material-request', [
            'title' => 'Laptop', 'specification' => 'x',
            'attached_file' => UploadedFile::fake()->create('script.html', 5, 'text/html'),
        ])->assertSessionHasErrors('attached_file');

        $this->assertSame(0, Material::count());
    }

    public function test_two_attachments_with_the_same_name_are_both_kept(): void
    {
        $this->actingAs($this->collaborator)->post('/document-request', [
            'type' => 'work certificate', 'title' => 'x', 'description' => 'x',
            'attached_files' => [UploadedFile::fake()->create('scan.pdf', 5), UploadedFile::fake()->create('scan.pdf', 5)],
        ]);

        $names = json_decode(Document::sole()->attached_files);
        $this->assertCount(2, array_unique($names));
    }

    public function test_remote_work_dates_cannot_be_in_the_past(): void
    {
        $this->actingAs($this->collaborator)->post('/homework-request', [
            'description' => 'x', 'from_date' => now()->subWeek()->toDateString(), 'to_date' => now()->subDay()->toDateString(),
        ])->assertSessionHasErrors('from_date');
    }

    public function test_admin_creates_a_user_with_every_field(): void
    {
        $this->actingAs($this->admin)->post(route('user-management.store'), [
            'firstname' => 'Fatima-Zahra', 'lastname' => 'El Amrani', 'email' => 'fz@example.test',
            'role' => 'collaborator', 'phone' => '+212 612345678', 'sexe' => 'female',
            'dob' => '1995-04-02', 'job_title' => 'Accountant',
            'avatar' => UploadedFile::fake()->image('fz.png'),
            'password' => 'secret-pass-1', 'password_confirmation' => 'secret-pass-1',
        ])->assertRedirect(route('user-management.index'));

        $user = User::where('email', 'fz@example.test')->sole();
        $this->assertSame('1995-04-02', $user->dob->toDateString());
        $this->assertSame('collaborator', $user->role);
        $this->assertNotNull($user->avatar);
        Storage::disk('local')->assertExists('public/photos/' . $user->avatar);
    }

    public function test_the_people_list_offers_no_delete_for_the_super_admin(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $this->actingAs($this->admin)->get(route('user-management.index'))
            ->assertSee("confirm-user-deletion-{$this->collaborator->id}')", false)
            ->assertDontSee("confirm-user-deletion-{$superAdmin->id}')", false);
    }

    public function test_creating_a_user_requires_a_role(): void
    {
        $this->actingAs($this->admin)->post(route('user-management.store'), [
            'firstname' => 'Sara', 'lastname' => 'Bennani', 'email' => 'sara@example.test',
            'password' => 'secret-pass-1', 'password_confirmation' => 'secret-pass-1',
        ])->assertSessionHasErrors('role');
    }

    public function test_user_pages_render(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('user-management.index', ['search' => 'a']))->assertOk();
        $this->get(route('user-management.show', $this->collaborator->id))->assertOk();
    }

    public function test_super_admin_cannot_delete_their_own_account(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $this->actingAs($superAdmin)->delete('/profile', ['password' => 'password'])
            ->assertSessionHasErrorsIn('userDeletion', 'password');

        $this->assertNotSoftDeleted($superAdmin);
    }

    public function test_profile_accepts_compound_names_and_saves_the_avatar(): void
    {
        $this->actingAs($this->collaborator)->patch('/profile', [
            'firstname' => 'Anne-Marie', 'lastname' => "O'Neil", 'email' => $this->collaborator->email,
            'avatar' => UploadedFile::fake()->image('me.png'),
        ])->assertSessionHasNoErrors();

        $user = $this->collaborator->fresh();
        $this->assertSame('Anne-Marie', $user->firstname);
        Storage::disk('local')->assertExists('public/photos/' . $user->avatar);
    }

    public function test_collaborator_history_lists_their_requests(): void
    {
        $this->requests();
        $this->actingAs($this->collaborator)->get(route('collaborator-history'))->assertOk()->assertSee('Payslip');
    }

    public function test_leave_duration_counts_the_first_and_last_day(): void
    {
        $vacation = Vacation::create(['title' => 'Trip', 'description' => 'x', 'from' => '2026-10-17', 'to' => '2026-10-21', 'paid' => true, 'user_id' => $this->collaborator->id]);

        $this->assertSame(5, $vacation->fresh()->days());
        $this->actingAs($this->admin)->get(route('vacation-management.show', $vacation->id))->assertSee('5 days');
    }

    public function test_every_status_email_renders(): void
    {
        $mails = [
            'document-management' => \App\Mail\DocumentStatusNotification::class,
            'material-management' => \App\Mail\MaterialStatusNotification::class,
            'vacation-management' => \App\Mail\VacationStatusNotification::class,
            'homework-management' => \App\Mail\HomeworkStatusNotification::class,
            'evaluation-management' => \App\Mail\EvaluationStatusNotification::class,
        ];

        foreach ($this->requests() as $prefix => $model) {
            foreach ([1, 2] as $status) {
                $html = (new $mails[$prefix]($model, $status))->render();
                $this->assertStringContainsString($this->collaborator->firstname, $html, $prefix);
            }
        }
    }

    public function test_detail_pages_preview_images_and_link_other_files(): void
    {
        $this->actingAs($this->collaborator)->post('/document-request', [
            'type' => 'work certificate', 'title' => 'x', 'description' => 'x',
            'attached_files' => [UploadedFile::fake()->image('id-card.png'), UploadedFile::fake()->create('contract.pdf', 5, 'application/pdf')],
        ]);
        [$image, $pdf] = json_decode(Document::sole()->attached_files);

        $this->actingAs($this->admin)->get(route('document-management.show', Document::sole()->id))
            ->assertOk()
            ->assertSee('<img src="' . asset('storage/documents/' . $image) . '"', false)
            ->assertSee('href="' . asset('storage/documents/' . $pdf) . '" download', false);
    }

    public function test_two_avatars_uploaded_in_the_same_second_do_not_overwrite_each_other(): void
    {
        $other = User::factory()->create();
        foreach ([$this->collaborator, $other] as $user) {
            $this->actingAs($user)->patch('/profile', [
                'firstname' => $user->firstname, 'lastname' => $user->lastname, 'email' => $user->email,
                'avatar' => UploadedFile::fake()->image('me.png'),
            ]);
        }

        $this->assertNotSame($this->collaborator->fresh()->avatar, $other->fresh()->avatar);
    }

    public function test_hr_lists_load_people_in_one_query(): void
    {
        foreach (range(1, 15) as $i) {
            $this->requests();
            User::factory()->create(); // a fresh owner each round would add queries per row without eager loading
        }
        $this->actingAs($this->admin);

        foreach (['dashboard', 'admin-history', 'vacation-management.index', 'homework-management.index',
            'document-management.index', 'material-management.index', 'evaluation-management.index'] as $route) {
            \DB::enableQueryLog();
            \DB::flushQueryLog();
            $this->get(route($route))->assertOk();
            $this->assertLessThan(25, count(\DB::getQueryLog()), $route);
        }
    }
}
