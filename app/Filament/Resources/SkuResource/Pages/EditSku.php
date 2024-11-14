<?php

namespace App\Filament\Resources\SkuResource\Pages;

use App\Filament\Resources\SkuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditSku extends EditRecord
{
    protected static string $resource = SkuResource::class;

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['update Sku']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
