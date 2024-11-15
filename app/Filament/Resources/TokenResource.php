<?php

namespace App\Filament\Resources;

use App\Constants\DefaultRoles;
use App\Filament\Resources\TokenResource\Pages;
use App\Models\Token;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TokenResource extends Resource
{
    protected static ?string $model = Token::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->canAny(['view-any Token', 'view Token']);
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('purchase_token')
                    ->label('Token')
                    ->required()
                    ->placeholder('Token'),
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
                Forms\Components\Select::make('sku_id')
                    ->label('Sku')
                    ->required()
                    ->options(\App\Models\Sku::pluck('product_id', 'id')->toArray()),
                Forms\Components\TextInput::make('original_json')
                    ->label('Original Json')
                    ->json()
                    ->placeholder('Original Json'),
                Forms\Components\TextInput::make('signature')
                    ->label('Signature')
                    ->placeholder('Signature'),
                Forms\Components\TextInput::make('order_id')
                    ->label('Order Id')
                    ->placeholder('Order Id'),

                Forms\Components\Hidden::make('owner_id')
                    ->default(auth()->id()),
                Forms\Components\Hidden::make('created_by')
                    ->default(auth()->id())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('owner.username')
                    ->label('Owner')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sku.product_id')
                    ->label('Sku')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_token')
                    ->label('Token')
                    ->searchable()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListTokens::route('/'),
            'create' => Pages\CreateToken::route('/create'),
//            'edit' => Pages\EditToken::route('/{record}/edit'),
        ];
    }
}
