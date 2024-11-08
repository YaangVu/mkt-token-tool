<?php

namespace App\Filament\Resources;

use Illuminate\Database\Eloquent\Model;

class PermissionResource extends \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource
{
    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->isSuperAdmin();
    }
}
