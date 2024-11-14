<?php

namespace App\Filament\Resources\TokenPumpResource\Pages;

use App\Filament\Resources\TokenPumpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTokenPump extends EditRecord
{
    protected static string $resource = TokenPumpResource::class;

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['update TokenPump']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
