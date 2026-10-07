<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Demo accounts for local development (password: "password").
     * In production, create the first super admin with `php artisan app:create-user`.
     */
    public function run(): void
    {
        User::factory()->superAdmin()->create([
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'email' => 'superadmin@requestify.test',
        ]);

        User::factory()->admin()->create([
            'firstname' => 'Hr',
            'lastname' => 'Admin',
            'email' => 'admin@requestify.test',
        ]);

        User::factory()->create([
            'firstname' => 'Demo',
            'lastname' => 'Collaborator',
            'email' => 'collaborator@requestify.test',
            'job_title' => 'Developer',
        ]);
    }
}
