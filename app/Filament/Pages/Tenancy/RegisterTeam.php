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
                // ...
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        /**
         * @var Team $team
         */
        $team = Team::create([...$data, ...['created_by' => auth()->user()->id]]);

        // Attach the current user to the team as an admin
        auth()->user()->teams()->attach(auth()->id(), ['team_id' => $team->id, 'role_id' => Role::whereName(DefaultRoles::TEAM_ADMIN)->first()->id]);

        // Attach TeamAdmin role to the current user
        Role::whereName(DefaultRoles::TEAM_ADMIN)->first()->users()->attach(auth()->user(), ['team_id' => $team->id]);


        return $team;
    }
}
