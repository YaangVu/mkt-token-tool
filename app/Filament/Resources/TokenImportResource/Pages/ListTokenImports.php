<?php

namespace App\Filament\Resources\TokenImportResource\Pages;

use App\Filament\Resources\TokenImportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTokenImports extends ListRecords
{
    protected static string $resource = TokenImportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
