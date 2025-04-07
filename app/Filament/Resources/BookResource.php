<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = "Resources";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        TextInput::make('title')
                            ->columnSpan(2),

                        TextInput::make('isbn')
                            ->label('ISBN'),

                        Forms\Components\Group::make()
                            ->relationship('category')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Category'),
                            ]),

                        Forms\Components\Group::make()
                            ->relationship('library')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Library')
                            ]),

                        TextInput::make('author'),
                        TextInput::make('publisher'),
                        TextInput::make('pages')
                            ->label('Total Pages'),

                        DatePicker::make('publication_date')
                            ->date(),

                        Forms\Components\TextInput::make('stock')
                            ->label('Current Stock')
                            ->disabled(),

                        Textarea::make('synopsis')
                            ->columnSpan(2)
                            ->label('Description'),
                    ])
                    ->columns(2)
                ->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->collection('book')
                            ->columnSpan(2),

                        Forms\Components\Section::make('Book Stats')
                            ->label('Book Stats')
                            ->schema([

                                Forms\Components\Placeholder::make('total_borrowed')
                                    ->label('Total Borrowings')
                                    ->content(fn ($record) => $record->borrowings()->count())
                                    ->disabled(),

                                Forms\Components\Placeholder::make('total_likes')
                                    ->label('Total Likes')
                                    ->content(fn ($record) => $record->likes()->count())
                                    ->disabled(),

                                Forms\Components\Placeholder::make('total_reviews')
                                    ->label('Total Comments')
                                    ->content(fn ($record) => $record->bookComents()->count())
                                    ->disabled(),
                            ])
                    ])->columnSpan(['lg' => 1])
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('cover')
                    ->label('Cover')
                    ->collection('book')
                    ->height(50)
                    ->width(50),

                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable()
                    ->limit(30),

                TextColumn::make('library.name')
                    ->label('Library'),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category'),

                Tables\Columns\TextColumn::make('publication_date')
                    ->label('Publication Date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),

                Tables\Filters\SelectFilter::make('library')
                    ->label('Library')
                    ->relationship('library', 'name')
                    ->preload()
                    ->searchable(),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\BorrowingsRelationManager::class,
            RelationManagers\LikesRelationManager::class,
            RelationManagers\BookComentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'view' => Pages\ViewBook::route('/{record}'),
        ];
    }
}
