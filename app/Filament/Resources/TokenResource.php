<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TokenResource\Pages;
use App\Models\Token;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TokenResource extends Resource
{
    protected static ?string $model = Token::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('token')
                    ->label('Token')
                    ->required()
                    ->placeholder('Token'),
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
                Forms\Components\Select::make('package_id')
                    ->label('Package')
                    ->required()
                    ->options(\App\Models\Package::pluck('title', 'id')->toArray()),
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('client.username')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('package.title')
                    ->label('Package')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_token')
                    ->label('Token')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('export_history_id')
                    ->label('Export History')
                    ->sortable(),
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
            'index' => Pages\ListTokens::route('/'),
            'create' => Pages\CreateToken::route('/create'),
//            'edit' => Pages\EditToken::route('/{record}/edit'),
        ];
    }
}
