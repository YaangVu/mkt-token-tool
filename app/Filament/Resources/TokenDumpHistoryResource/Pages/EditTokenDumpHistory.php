<?php

namespace App\Filament\Resources\TokenDumpHistoryResource\Pages;

use App\Filament\Resources\TokenDumpHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTokenDumpHistory extends EditRecord
{
    protected static string $resource = TokenDumpHistoryResource::class;

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['update TokenDumpHistory']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
