<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibraryResource\Pages;
use App\Filament\Resources\LibraryResource\RelationManagers;
use App\Models\Library;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LibraryResource extends Resource
{
    protected static ?string $model = Library::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = "Library Operations";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('address')
                    ->required(),
                TextInput::make('email')
                    ->required(),
                TextInput::make('phone')
                    ->required(),
                TimePicker::make('opening_time')
                    ->required(),
                TimePicker::make('closing_time')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Library')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address')
                    ->limit(20),
                TextColumn::make('email'),
                TextColumn::make('phone')
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BooksRelationManager::class,
            RelationManagers\LibrariansRelationManager::class,
            RelationManagers\RoomsRelationManager::class,
            RelationManagers\MemberVisitsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibraries::route('/'),
            'create' => Pages\CreateLibrary::route('/create'),
            'view' => Pages\ViewLibrary::route('/{record}'),
            'edit' => Pages\EditLibrary::route('/{record}/edit'),
        ];
    }
}
