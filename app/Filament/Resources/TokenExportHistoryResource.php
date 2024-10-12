<?php

namespace App\Filament\Resources;

use App\Exports\TokenExport;
use App\Filament\Resources\TokenExportHistoryResource\Pages;
use App\Models\Token;
use App\Models\TokenExportHistory;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TokenExportHistoryResource extends Resource
{
    protected static ?string $model = TokenExportHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('User'),
                Tables\Columns\TextColumn::make('game.name')
                    ->searchable()
                    ->sortable()
                    ->label('Game'),
                Tables\Columns\TextColumn::make('package.title')
                    ->searchable()
                    ->sortable()
                    ->label('Package'),
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
                //
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (TokenExportHistory $history) {
                        Notification::make()
                            ->title('Download successfully')
                            ->success()
                            ->send();
                        return \Maatwebsite\Excel\Facades\Excel::download(new TokenExport($history->id), "tokens-$history->created_at.csv", \Maatwebsite\Excel\Excel::CSV);

                    }),
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function (TokenExportHistory $history) {
                        Token::whereExportHistoryId($history->id)->update(['export_history_id' => null]);
                        $history->delete();
                        Notification::make()
                            ->title('Restore successfully')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ])
            ->headerActions([
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
            'index' => Pages\ListTokenExportHistories::route('/'),

        ];
    }
}
