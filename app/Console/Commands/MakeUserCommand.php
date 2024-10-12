<?php

namespace App\Console\Commands;

use Filament\Facades\Filament;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class MakeUserCommand extends \Filament\Commands\MakeUserCommand
{
    protected $description = 'Create a new User';

    protected $signature = 'make:user
                            {--name= : The name of the user}
                            {--username= : A valid and unique username}
                            {--email= : A valid and unique email}
                            {--password= : The password for the user (min. 8 characters)}';

    protected function getUserData(): array
    {
        return [
            'name' => $this->options['name'] ?? text(
                    label: 'Name',
                    required: true,
                ),

            'username' => $this->options['username'] ?? text(
                    label: 'Username',
                    required: true,
                    validate: fn(string $username): ?string => match (true) {
                        static::getUserModel()::where('username', $username)->exists() => 'A user with this username already exists',
                        default => null,
                    },
                ),

            'email' => $this->options['email'] ?? text(
                    label: 'Email',
                    required: true,
                    validate: fn(string $email): ?string => match (true) {
                        static::getUserModel()::where('email', $email)->exists() => 'A user with this email already exists',
                        default => null,
                    },
                ),

            'password' => Hash::make($this->options['password'] ?? password(
                label: 'Password',
                required: true,
            )),
        ];
    }

    protected function getUserModel(): string
    {
        /** @var EloquentUserProvider $provider */
        $provider = $this->getUserProvider();

        return $provider->getModel();
    }

    protected function getUserProvider(): UserProvider
    {
        return $this->getAuthGuard()->getProvider();
    }

    protected function getAuthGuard(): Guard
    {
        return Filament::auth();
    }
}
