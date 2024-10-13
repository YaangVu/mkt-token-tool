<?php

namespace App\Filament\Resources\TokenImportResource\Pages;

use App\Filament\Resources\TokenImportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTokenImport extends EditRecord
{
    protected static string $resource = TokenImportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
