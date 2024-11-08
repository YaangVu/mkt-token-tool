<?php

namespace App\Filament\Resources;

use Illuminate\Database\Eloquent\Model;

class RoleResource extends \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource
{
public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->isSuperAdmin();
    }
}
