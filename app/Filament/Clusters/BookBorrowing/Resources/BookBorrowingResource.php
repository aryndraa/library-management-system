<?php

namespace App\Filament\Clusters\BookBorrowing\Resources;

use App\Filament\Clusters\BookBorrowing;
use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource\Pages;
use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource\RelationManagers;
use App\Models\BorrowedBook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookBorrowingResource extends Resource
{
    protected static ?string $model = BorrowedBook::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?string $label = 'Borrowing Books';

    protected static ?string $cluster = BookBorrowing::class;

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
            ->query(
                BorrowedBook::query()->where('status', 'borrowed')
            )
            ->columns([
                TextColumn::make('code')
                    ->limit('30')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('book.title')
                    ->limit('30')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('member.first_name')
                    ->getStateUsing(fn ($record) =>
                        $record->member->profile->first_name .
                        ' '
                        . $record->member->profile->last_name
                    )
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->color('success'),

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
            'index' => Pages\ListBookBorrowings::route('/'),
            'create' => Pages\CreateBookBorrowing::route('/create'),
            'edit' => Pages\EditBookBorrowing::route('/{record}/edit'),
        ];
    }
}
