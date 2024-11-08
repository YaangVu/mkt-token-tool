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
        $team = Team::create([...$data, ...['created_by' => auth()->user()->id]]);

        $team->users()->attach(auth()->user(), ['created_at' => now(), 'updated_at' => now()]);

        Role::whereName(DefaultRoles::TEAM_ADMIN)->first()->users()->attach(auth()->user(), ['team_id' => $team->id]);

        return $team;
    }
}
