<?php

namespace App\Filament\Resources\TokenImportResource\Pages;

use App\Filament\Resources\TokenImportResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTokenImport extends CreateRecord
{
    protected static string $resource = TokenImportResource::class;

     public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['create TokenImport']);
    }
}
