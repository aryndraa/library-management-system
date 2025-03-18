<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibrarianResource\Pages;
use App\Filament\Resources\LibrarianResource\RelationManagers;
use App\Models\Librarian;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LibrarianResource extends Resource
{
    protected static ?string $model = Librarian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Librarian';

    protected static ?string $label = 'Librarians';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('library_id')
                    ->relationship('library', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('library.name')
                    ->searchable(),
                TextColumn::make('full_name')
                    ->label('Full Name')
                    ->formatStateUsing(fn ($record) =>
                        ($record->profile->first_name ?? '')
                            . ' ' .
                        ($record->profile->last_name ?? ''))
                    ->searchable(),

            ])
            ->filters([
                SelectFilter::make('library')
                    ->relationship('library', 'name')
                    ->searchable()
                    ->preload()
                    ->attribute('library.name'),

            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibrarians::route('/'),
            'create' => Pages\CreateLibrarian::route('/create'),
            'edit' => Pages\EditLibrarian::route('/{record}/edit'),
        ];
    }
}
