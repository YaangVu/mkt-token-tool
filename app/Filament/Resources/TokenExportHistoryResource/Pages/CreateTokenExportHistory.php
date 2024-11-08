<?php

namespace App\Filament\Resources\TokenExportHistoryResource\Pages;

use App\Filament\Resources\TokenExportHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTokenExportHistory extends CreateRecord
{
    protected static string $resource = TokenExportHistoryResource::class;

     public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['create TokenExportHistory']);
    }
}
