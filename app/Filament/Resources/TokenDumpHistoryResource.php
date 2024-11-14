<?php

namespace App\Filament\Resources;

use App\Exports\TokenExport;
use App\Filament\Resources\TokenDumpHistoryResource\Pages;
use App\Models\Token;
use App\Models\TokenDumpHistory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TokenDumpHistoryResource extends Resource
{
    protected static ?string $model = TokenDumpHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-on-square-stack';

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->canAny(['view-any TokenDumpHistory', 'view TokenDumpHistory']);
    }

    public static function getNavigationLabel(): string
    {
        return 'Quản lý xả';
    }

    public static function getNavigationSort(): ?int
    {
        return 0;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('User'),
                Tables\Columns\TextColumn::make('sku.game_name')
                    ->searchable()
                    ->sortable()
                    ->label('Game'),
                Tables\Columns\TextColumn::make('sku.title')
                    ->searchable()
                    ->sortable()
                    ->label('Sku'),
                Tables\Columns\TextColumn::make('quantity')
                    ->searchable()
                    ->sortable()
                    ->label('Quantity'),
                Tables\Columns\TextColumn::make('created_at')
                    ->searchable()
                    ->sortable()
                    ->label('Created At'),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_from')
                    ->form([
                        DatePicker::make('created_from')->default(Carbon::now()->subDays(7)),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['created_from'],
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        );
                    }),
                Tables\Filters\Filter::make('created_until')
                    ->form([
                        DatePicker::make('created_until')->default(Carbon::now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['created_until'],
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                    })
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(2)
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (TokenDumpHistory $history) {
                        Notification::make()
                            ->title('Download successfully')
                            ->success()
                            ->send();
                        return \Maatwebsite\Excel\Facades\Excel::download(new TokenExport($history->id), "tokens-$history->created_at.csv", \Maatwebsite\Excel\Excel::CSV);

                    }),
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function (TokenDumpHistory $history) {
                        Token::whereDumpHistoryId($history->id)->update(['dump_history_id' => null]);
                        $history->delete();
                        Notification::make()
                            ->title('Restore successfully')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ])
            ->headerActions([
                //
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListTokenDumpHistories::route('/'),

        ];
    }
}
