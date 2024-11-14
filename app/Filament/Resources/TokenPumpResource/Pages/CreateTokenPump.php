<?php

namespace App\Filament\Resources\TokenPumpResource\Pages;

use App\Filament\Resources\TokenPumpResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTokenPump extends CreateRecord
{
    protected static string $resource = TokenPumpResource::class;

     public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['create TokenPump']);
    }
}
