<?php

namespace App\Filament\Resources\MemberResource\RelationManagers;

use App\Models\BorrowedBook;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BorrowedBooksRelationManager extends RelationManager
{
    protected static string $relationship = 'borrowedBooks';

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->relationship('book')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('isbn')
                            ->required()
                            ->unique()
                            ->maxLength(13)
                            ->label('ISBN'),
                        Select::make('library_id')
                            ->relationship('library', 'name')
                            ->required()
                            ->label('Library'),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Category')
                            ->required(),
                        TextInput::make('author'),
                        TextInput::make('publisher'),
                        TextInput::make('pages')
                            ->required()
                            ->numeric(),
                        DatePicker::make('publication_date')
                            ->required()
                            ->date()
                    ])
                    ->columns(2)
                    ->columnSpan(2),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('borrowed_date')
                            ->label('Borrowed Date')
                            ->content(fn (BorrowedBook $record): ?string => $record->borrowed_date),

                        Forms\Components\Placeholder::make('returned_date')
                            ->label('Returned Date')
                            ->content(fn (BorrowedBook $record): ?string => $record->returned_date),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?BorrowedBook $record) => $record === null)
            ])
            ->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('book.isbn')
                    ->label('ISBN'),
                TextColumn::make('book.library.name')
                    ->label('Library'),
                TextColumn::make('book.title')
                    ->label('Title'),
                TextColumn::make('book.category.name')
                    ->label('Category'),
                TextColumn::make('borrowed_date')
                    ->date(),
                TextColumn::make('returned_date')
                    ->date()

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
