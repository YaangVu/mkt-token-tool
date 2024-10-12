<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Models\Game;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->label('Code'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Title'),
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
                Tables\Columns\TextColumn::make('currency')
                    ->searchable()
                    ->label('Currency'),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('User'),
                Tables\Columns\TextColumn::make('game.name')
                    ->searchable()
                    ->sortable()
                    ->label('Game'),
//                Tables\Columns\TextColumn::make('created_at')
//                    ->sortable()
//                    ->label('Created At'),
                Tables\Columns\TextColumn::make('tokens_count')
                    ->label('Tokens')
                    ->counts(['tokens' => function ($query) {
                        $query->whereNull('export_history_id');
                    }])
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('tokens')
                    ->label('Export Tokens')
                    ->icon('heroicon-o-cloud-arrow-down')
                    ->fillForm(fn(Package $package): array => [
                        'package_id' => $package->id,
                        'game_name' => $package->game->name,
                        'price' => $package->price,
                        'package_name' => $package->title,
                        'remaining_tokens' => $package->tokens()->whereNull('export_history_id')->count(),
                    ])
                    ->form([
                        Forms\Components\TextInput::make('package_id')
                            ->hidden(),
                        Forms\Components\TextInput::make('game_name')
                            ->label('Game Name')
                            ->disabled(),
                        Forms\Components\TextInput::make('package_name')
                            ->label('Package Name')
                            ->disabled(),
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->disabled(),
                        Forms\Components\TextInput::make('remaining_tokens')
                            ->label('Remaining Tokens')
                            ->disabled(),
                        Forms\Components\TextInput::make('quantity_tokens')
                            ->label('Quantity Tokens')
                            ->numeric()
                            ->maxValue(fn($get) => $get('remaining_tokens')),
                    ])
                    ->action(function (array $data, Package $package) {
                        $package->exportTokens($data['quantity_tokens'], $package);
                        return Notification::make()
                            ->title($data['quantity_tokens'] . ' tokens were exported successfully')
                            ->success()
                            ->send();
                    }),
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
                Forms\Components\TextInput::make('code')
                    ->label('Code')
                    ->required()
                    ->placeholder('Code'),
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->placeholder('Package Title'),
                Forms\Components\TextInput::make('type')
                    ->label('Type')
                    ->placeholder('Type'),
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->placeholder('100.00'),
                Forms\Components\TextInput::make('currency')
                    ->label('Currency')
                    ->required()
                    ->default('USD')
                    ->placeholder('USD'),
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
                Forms\Components\Select::make('game_id')
                    ->label('Game')
                    ->required()
                    ->options(Game::pluck('name', 'id')->toArray()),

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
