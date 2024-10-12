<?php

namespace App\Filament\Resources\TokenExportHistoryResource\Pages;

use App\Filament\Resources\TokenExportHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTokenExportHistories extends ListRecords
{
    protected static string $resource = TokenExportHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
