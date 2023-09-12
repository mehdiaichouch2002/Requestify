<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user with super admin role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $firstName = $this->ask('Enter first name:');
        $lastName = $this->ask('Enter last name:');
        $email = $this->ask('Enter email:');
        $password = $this->secret('Enter password:');
        $confirmPassword = $this->secret('Confirm password:');

        $validator = \Illuminate\Support\Facades\Validator::make([
            'firstname' => $firstName,
            'lastname' => $lastName,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $confirmPassword,
        ], [
            'firstname' => 'required|string|min:3|max:30|regex:/^[a-zA-Z]+$/',
            'lastname' => 'required|string|min:3|max:30|regex:/^[a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('firstname')) {
                $this->error('Invalid first name. Please try again.');
            }
            if ($errors->has('lastname')) {
                $this->error('Invalid last name. Please try again.');
            }
            if ($errors->has('email')) {
                $emailErrors = $errors->get('email');
                foreach ($emailErrors as $error) {
                    if ($error == 'The email has already been taken.') {
                        $this->error('The email has already been taken.');
                    } else {
                        $this->error('Invalid email format. Please enter a valid email address.');
                    }
                }
            }
            if ($errors->has('password')) {
                $this->error('Invalid password. Please try again.');
            }
            if ($errors->has('password_confirmation')) {
                $this->error('Passwords do not match. Please try again.');
            }
            return;
        }

        $user = new User();
        $user->firstname = $firstName;
        $user->lastname = $lastName;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->role = 'super-admin';
        $user->save();

        $this->info('User created successfully!');
    }
}
