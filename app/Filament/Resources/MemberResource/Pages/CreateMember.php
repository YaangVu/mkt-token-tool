<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Constants\DefaultRoles;
use App\Filament\Resources\MemberResource;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateMember extends CreateRecord
{
    protected static string $resource = MemberResource::class;

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['create Member']);
    }

    protected function handleRecordCreation(array $data): Model
    {
        /**
         * @var User $record
         */
        $record = parent::handleRecordCreation($data);
        $this->attachRolesAndTeamToNewMember($record);
        return $record;
    }

    /**
     * Attach the roles and team to the new member
     *
     * @param User $newMember
     */
    protected function attachRolesAndTeamToNewMember(User $newMember): void
    {
        /**
         * @var Team $team
         */
        $team = Filament::getTenant();
        Role::whereName(DefaultRoles::TEAM_MEMBER)->each(function (Role $role) use ($newMember, $team) {
            // Attach the role to the current user
            $role->users()->attach($newMember->id, ['team_id' => $team?->id]);

            // Attach the current user to the team
            $newMember->teams()->attach($team?->id, ['role_id' => $role->id]);
        });
    }

}
