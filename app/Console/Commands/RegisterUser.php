<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;




class RegisterUser extends Command
{
    protected $signature = 'user:register';
    protected $description = 'Register a new user';


    public function handle()
    {
        $data = [
            'username' => $this->ask('Enter the user name'),
            'email' => $this->ask('Enter the user email'),
            'password' => $this->secret('Enter the user password'),
            'password_confirmation' => $this->secret('Confirm the user password'),
            'role' => $this->choice('Select role', ['USER', 'SUPER_USER']),
        ];

        $validator = Validator::make($data, [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        $this->info('User registered successfully: ' . $user->name);
        return 0;
    }
}