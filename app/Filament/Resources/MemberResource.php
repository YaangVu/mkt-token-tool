<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Quản lý thành viên';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->placeholder('john_doe'),
                Forms\Components\TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->placeholder('John Doe'),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->placeholder(' [email protected]'),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->placeholder('********')
                    ->password()
                    ->autocomplete('new-password'),

            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->sortable()
                    ->label('Username'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Full Name'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('created_at')
                    ->date('Y-m-d')
                    ->label('Created At'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn(Model $record): bool => auth()->user()->can('update Member')),
                Tables\Actions\DeleteAction::make('delete')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-trash')
                    ->visible(fn(): bool => auth()->user()->can('delete Member')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->visible(fn(): bool => auth()->user()->can('delete Member')),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->canAny(['view-any Member', 'view Member']);
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
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
