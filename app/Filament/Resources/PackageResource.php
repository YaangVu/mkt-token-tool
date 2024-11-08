<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->canAny(['view-any Package', 'view Package']);
    }

    public static function getNavigationSort(): ?int
    {
        return -2;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),
                Tables\Columns\TextColumn::make('game_name')
                    ->searchable()
                    ->sortable()
                    ->label('Game Name'),
                Tables\Columns\TextColumn::make('product_id')
                    ->searchable()
                    ->sortable()
                    ->label('Product ID'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Package Name'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Package Title'),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->sortable()
                    ->label('Type'),
                Tables\Columns\TextColumn::make('price')
                    ->searchable()
                    ->sortable()
                    ->label('Price')
                    ->prefix('$ ')
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('price_currency_code')
                    ->searchable()
                    ->label('Currency Code'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->requiresConfirmation(),
                ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_id')
                    ->label('Product ID')
                    ->required()
                    ->placeholder('700coins.global.multi'),
                Forms\Components\TextInput::make('game_name')
                    ->label('Game Name')
                    ->required()
                    ->placeholder('Tiktok'),
                Forms\Components\TextInput::make('name')
                    ->label('Package Name')
                    ->required()
                    ->placeholder('com.zhiliaoapp.musically'),
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->placeholder('Package Title'),
                Forms\Components\TextInput::make('type')
                    ->label('Type')
                    ->placeholder('700 coins (TikTok)')
                    ->default('inapp'),
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->placeholder('100.00'),
                Forms\Components\Select::make('price_currency_code')
                    ->label('Currency')
                    ->required()
                    ->options([
                        'USD' => 'USD',
                        'EUR' => 'EUR',
                        'GBP' => 'GBP',
                    ]),
                Forms\Components\Hidden::make('created_by')
                    ->default(auth()->id())
                    ->required(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
