<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TokenImportResource\Pages;
use App\Models\TokenImport;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TokenImportResource extends Resource
{
    protected static ?string $model = TokenImport::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->label('Game Title'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Package Name'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Package Title'),
                Tables\Columns\TextColumn::make('price')
                    ->searchable()
                    ->sortable()
                    ->label('Price')
                    ->prefix('$ ')
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('price_currency_code')
                    ->searchable()
                    ->label('Currency Code'),
                Tables\Columns\TextColumn::make('tokens_count')
                    ->label('Quantity')
                    ->counts(['tokens' => function ($query) {
                        $query->whereNull('export_history_id');
                    }])
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('tokens')
                    ->label('Export Tokens')
                    ->icon('heroicon-o-cloud-arrow-down')
                    ->requiresConfirmation()
                    ->fillForm(fn(TokenImport $import): array => [
                        'package_id' => $import->id,
                        'game_name' => $import->game_name,
                        'price' => $import->price,
                        'name' => $import->name,
                        'remaining_tokens' => $import->tokens()->whereNull('export_history_id')->count(),
                    ])
                    ->form([
                        TextInput::make('package_id')
                            ->hidden(),
                        TextInput::make('name')
                            ->label('Package Name')
                            ->disabled(),
                        TextInput::make('price')
                            ->label('Price')
                            ->disabled(),
                        TextInput::make('remaining_tokens')
                            ->label('Remaining Tokens')
                            ->disabled(),
                        TextInput::make('quantity_tokens')
                            ->label('Quantity Tokens')
                            ->numeric()
                            ->maxValue(fn($get) => $get('remaining_tokens')),
                    ])
                    ->action(function (array $data, TokenImport $package) {
                        $package->exportTokens($data['quantity_tokens'], $package);
                        return Notification::make()
                            ->title($data['quantity_tokens'] . ' tokens were exported successfully')
                            ->success()
                            ->send();
                    })
                    ,
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->requiresConfirmation(),
                ]),
            ])
            ->headerActions([
                //
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
            'index' => Pages\ListTokenImports::route('/')
        ];
    }
}
