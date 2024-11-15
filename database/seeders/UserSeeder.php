<?php

namespace Database\Seeders;

use App\Constants\DefaultRoles;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
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

        $team = Team::first();

        Role::whereIn('name', [DefaultRoles::SUPER_ADMIN, DefaultRoles::TEAM_ADMIN])->each(function (Role $role) use ($user, $team) {
            // Attach the role to the current user
            $role->users()->attach($user->id, ['team_id' => $team?->id]);

            // Attach the current user to the team
            $user->teams()->attach($team?->id, ['role_id' => $role->id]);
        });
    }
}
