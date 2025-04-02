<?php

namespace App\Filament\Clusters\Librarian\Resources;

use App\Filament\Clusters\Librarian;
use App\Filament\Clusters\Librarian\Resources\LibrarianShiftResource\Pages;
use App\Filament\Clusters\Librarian\Resources\LibrarianShiftResource\RelationManagers;
use App\Models\LibrarianShift;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LibrarianShiftResource extends Resource
{
    protected static ?string $model = LibrarianShift::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';

    protected static ?string $cluster = Librarian::class;

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
            'index' => Pages\ListLibrarianShifts::route('/'),
            'create' => Pages\CreateLibrarianShift::route('/create'),
            'edit' => Pages\EditLibrarianShift::route('/{record}/edit'),
        ];
    }
}
