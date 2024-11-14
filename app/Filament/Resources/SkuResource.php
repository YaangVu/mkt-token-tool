<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkuResource\Pages;
use App\Models\Sku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SkuResource extends Resource
{
    protected static ?string $model = Sku::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->canAny(['view-any Sku', 'view Sku']);
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
                Tables\Columns\TextColumn::make('product_id')
                    ->searchable()
                    ->sortable()
                    ->label('Product ID'),
                Tables\Columns\TextColumn::make('game_name')
                    ->searchable()
                    ->sortable()
                    ->label('Game Name'),

                Tables\Columns\TextColumn::make('package_name')
                    ->searchable()
                    ->sortable()
                    ->label('Package Name'),

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
            ])
            ->defaultSort('id', 'desc');
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
                Forms\Components\TextInput::make('package_name')
                    ->label('Package Name')
                    ->required()
                    ->placeholder('com.zhiliaoapp.musically'),
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
            'index' => Pages\ListSkus::route('/'),
            'create' => Pages\CreateSku::route('/create'),
            'edit' => Pages\EditSku::route('/{record}/edit'),
        ];
    }
}
