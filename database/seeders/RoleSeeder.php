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
        $teamAdminRole = Role::create(['name' => DefaultRoles::TEAM_ADMIN]);
        $teamMemberRole = Role::create(['name' => DefaultRoles::TEAM_MEMBER]);

        $this->assignPermissionsToTeamAdminRole($teamAdminRole);
        $this->assignPermissionsToTeamMemberRole($teamMemberRole);

        Role::create(['name' => DefaultRoles::SUPER_ADMIN, 'guard_name' => 'api']);
        $teamAdminRoleApi = Role::create(['name' => DefaultRoles::TEAM_ADMIN, 'guard_name' => 'api']);
        $teamMemberRoleApi = Role::create(['name' => DefaultRoles::TEAM_MEMBER, 'guard_name' => 'api']);

        $this->assignPermissionsToTeamAdminRole($teamAdminRoleApi);
        $this->assignPermissionsToTeamMemberRole($teamMemberRoleApi);
    }

    // Assign all view permission to the team admin role
    public function assignPermissionsToTeamAdminRole(Role $teamAdminRole): void
    {
        $teamAdminRole->givePermissionTo(
            [
                'view-any Member',
                'view-any Sku',
                'view-any Token',
                'view-any TokenImport',
                'view-any TokenDumpHistory',
                'create Member',
                'create Sku',
                'create Token',
                'create TokenImport',
                'create TokenDumpHistory',
                'update Member',
                'update Sku',
                'update Token',
                'update TokenImport',
                'update TokenDumpHistory',
                'delete Member',
                'delete Sku',
                'delete Token',
                'delete TokenImport',
                'delete TokenDumpHistory',
                'delete-any Member',
                'delete-any Sku',
                'delete-any Token',
                'delete-any TokenImport',
                'delete-any TokenDumpHistory',
            ]);
    }

    // Assign all view permission to the team member role
    public function assignPermissionsToTeamMemberRole(Role $teamMemberRole): void
    {
        $teamMemberRole->givePermissionTo(
            [
                'view Sku',
                'view Token',
                'view TokenImport',
                'view TokenDumpHistory',
                'create Token',
                'create TokenImport',
                'create TokenDumpHistory',
                'update Token',
                'update TokenImport',
                'update TokenDumpHistory',
            ]);
    }
}
