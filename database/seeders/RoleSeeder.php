<?php

namespace Database\Seeders;

use App\Constants\DefaultRoles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => DefaultRoles::SUPER_ADMIN]);
        Role::create(['name' => DefaultRoles::TEAM_ADMIN]);
        Role::create(['name' => DefaultRoles::TEAM_MEMBER]);
    }
}
