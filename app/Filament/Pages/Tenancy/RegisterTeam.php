<?php

namespace App\Filament\Pages\Tenancy;

use App\Constants\DefaultRoles;
use App\Models\Role;
use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register team';
    }

    public static function canView(): bool
    {
        return true;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('coin_requested')->numeric(),
                // ...
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        /**
         * @var Team $team
         */
        $team = Team::create([...$data, ...['created_by' => auth()->user()->id]]);

        Role::whereName(DefaultRoles::TEAM_ADMIN)->each(function (Role $role) use ($team) {
            // Attach the role to the current user
            $role->users()->attach(auth()->id(), ['team_id' => $team->id]);

            // Attach the current user to the team
            auth()->user()->teams()->attach($team->id, ['role_id' => $role->id]);
        });

        return $team;
    }
}
