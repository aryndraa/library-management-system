<?php

namespace App\Filament\Clusters\Librarian\Resources;

use App\Filament\Clusters\Librarian\Resources\LibrarianResource\Pages;
use App\Filament\Clusters\Librarian\Resources\LibrarianResource\RelationManagers;
use App\Models\Librarian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LibrarianResource extends Resource
{
    protected static ?string $model = Librarian::class;

    protected static ?string $cluster = \App\Filament\Clusters\Librarian::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Profiles';

    protected static ?string $breadcrumb = 'Profiles';

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
