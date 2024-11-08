<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $user = User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

         $user->roles()->attach(1, ['team_id' => 1]); // Super Admin on Guard web
         $user->roles()->attach(4, ['team_id' => 1]); // Super Admin on Guard api
    }
}
