<?php

namespace App\Filament\Resources\TokenExportHistoryResource\Pages;

use App\Filament\Resources\TokenExportHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTokenExportHistory extends EditRecord
{
    protected static string $resource = TokenExportHistoryResource::class;

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['update TokenExportHistory']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
