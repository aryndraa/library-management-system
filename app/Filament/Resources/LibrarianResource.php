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
                    ->required(),
                Select::make('email'),
                Select::make('password')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
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
