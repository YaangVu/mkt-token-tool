<?php

namespace App\Filament\Resources\TokenResource\Pages;

use App\Filament\Resources\TokenResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateToken extends CreateRecord
{
    protected static string $resource = TokenResource::class;

     public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['create Token']);
    }
}
