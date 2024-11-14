<?php

namespace App\Filament\Resources\TokenPumpResource\Pages;

use App\Filament\Resources\TokenPumpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTokenPumps extends ListRecords
{
    protected static string $resource = TokenPumpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
