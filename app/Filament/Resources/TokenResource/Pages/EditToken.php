<?php

namespace App\Filament\Resources\TokenResource\Pages;

use App\Filament\Resources\TokenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditToken extends EditRecord
{
    protected static string $resource = TokenResource::class;

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['update Token']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
