<?php

namespace App\Filament\Resources\TokenExportHistoryResource\Pages;

use App\Filament\Resources\TokenExportHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTokenExportHistory extends EditRecord
{
    protected static string $resource = TokenExportHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
