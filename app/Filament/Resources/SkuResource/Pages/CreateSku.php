<?php

namespace App\Filament\Resources\SkuResource\Pages;

use App\Filament\Resources\SkuResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSku extends CreateRecord
{
    protected static string $resource = SkuResource::class;

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['create Sku']);
    }
}
