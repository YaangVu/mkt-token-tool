<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePackage extends CreateRecord
{
    protected static string $resource = PackageResource::class;

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['create Package']);
    }
}
