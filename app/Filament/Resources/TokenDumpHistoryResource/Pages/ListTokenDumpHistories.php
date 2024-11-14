<?php

namespace App\Filament\Resources\TokenDumpHistoryResource\Pages;

use App\Filament\Resources\TokenDumpHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTokenDumpHistories extends ListRecords
{
    protected static string $resource = TokenDumpHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
