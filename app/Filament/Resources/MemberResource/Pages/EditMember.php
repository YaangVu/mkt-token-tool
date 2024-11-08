<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditMember extends EditRecord
{
    protected static string $resource = MemberResource::class;

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['update Member']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
