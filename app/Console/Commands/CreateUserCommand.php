<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command {
    protected $signature = 'user:create';
    protected $description = 'Create a new user via the console';

    public function handle(): int {
        $name = $this->ask("User's name");
        $email = $this->ask("User's email address");

        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            $this->error('Invalid or already used email address.');

            return 1;
        }

        $password = $this->secret('Password');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("User '{$user->email}' successfully created.");

        return 0;
    }
}
