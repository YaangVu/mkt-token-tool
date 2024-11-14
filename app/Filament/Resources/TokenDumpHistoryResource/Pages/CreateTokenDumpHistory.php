<?php

namespace App\Filament\Resources\TokenDumpHistoryResource\Pages;

use App\Filament\Resources\TokenDumpHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTokenDumpHistory extends CreateRecord
{
    protected static string $resource = TokenDumpHistoryResource::class;

     public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['create TokenDumpHistory']);
    }
}
