<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TokenPumpResource\Pages;
use App\Models\TokenPump;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TokenPumpResource extends Resource
{
    protected static ?string $model = TokenPump::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square-stack';

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->canAny(['view-any TokenPump', 'view TokenPump']);
    }

    public static function getNavigationLabel(): string
    {
        return 'Quản lý nạp';
    }

    public static function getNavigationSort(): ?int
    {
        return -1;
    }

    public static function canCreate(): bool
    {
        return false;
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
                    ->label('Game Title'),
                Tables\Columns\TextColumn::make('package_name')
                    ->searchable()
                    ->sortable()
                    ->label('Package Name'),
                Tables\Columns\TextColumn::make('product_id')
                    ->searchable()
                    ->sortable()
                    ->label('Sku'),
                Tables\Columns\TextColumn::make('price')
                    ->searchable()
                    ->sortable()
                    ->label('Price')
                    ->prefix('$ ')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('dumpable_tokens_count')
                    ->label('Quantity')
                    ->counts('dumpableTokens')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Thành tiền')
                    ->getStateUsing(fn($record) => $record->price * $record->dumpable_tokens_count)
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_currency_code')
                    ->searchable()
                    ->label('Currency Code'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('tokens')
                    ->label('Export Tokens')
                    ->icon('heroicon-o-cloud-arrow-down')
                    ->requiresConfirmation()
                    ->fillForm(fn(TokenPump $import): array => [
                        'sku_id' => $import->id,
                        'game_name' => $import->game_name,
                        'price' => $import->price,
                        'name' => $import->name,
                        'remaining_tokens' => $import->tokens()->whereNull('dump_history_id')->count(),
                    ])
                    ->form([
                        TextInput::make('sku_id')
                            ->hidden(),
                        TextInput::make('name')
                            ->label('Sku Name')
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
                    ->action(function (array $data, TokenPump $sku) {
                        $sku->dumpTokens($data['quantity_tokens']);
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
            ])
            ->defaultSort('id', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('dumpableTokens');
            });

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
            'index' => Pages\ListTokenPumps::route('/')
        ];
    }
}
