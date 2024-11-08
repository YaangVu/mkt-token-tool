<?php

namespace App\Filament\Resources\TokenImportResource\Pages;

use App\Filament\Resources\TokenImportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTokenImport extends EditRecord
{
    protected static string $resource = TokenImportResource::class;

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['update TokenImport']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
