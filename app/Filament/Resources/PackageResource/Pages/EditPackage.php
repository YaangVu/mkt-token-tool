<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can(['update Package']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
