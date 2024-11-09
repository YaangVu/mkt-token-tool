<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $isScopedToTenant = false;

    protected static ?string $navigationGroup = 'Settings';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->can('view Team');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Team Name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Is Active')
                    ->sortable()
                    ->afterStateUpdated(function ($record, $state) {
                        $record->activated_at = $state ? now() : null;
                        $record->save();
                    }),
                Tables\Columns\TextColumn::make('activated_at')
                    ->label('Activated At')
                    ->sortable(),
                Tables\Columns\TextColumn::make('coin')
                    ->label('Coin')
                    ->sortable(),
                Tables\Columns\TextColumn::make('coin_requested')
                    ->label('Coin Requested')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expired_at')
                    ->label('Expired At')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('add_coin')
                    ->label('Add Coin')
                    ->icon('heroicon-s-currency-dollar')
                    ->requiresConfirmation()
                    ->form([
                        // Number of coins to add
                        TextInput::make('coin')
                            ->label('Coin')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->action(fn(Team $team, array $data) => $team->addCoin($data['coin']))
                ,
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTeams::route('/'),
//            'create' => Pages\CreateTeam::route('/create'),
//            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
