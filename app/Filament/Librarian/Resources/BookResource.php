<?php

namespace App\Filament\Librarian\Resources;

use App\Filament\Librarian\Resources\BookResource\Pages;
use App\Filament\Librarian\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Facades\Filament;
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

    protected static ?string $navigationGroup = 'Book Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        TextInput::make('title')
                            ->columnSpan(2)
                            ->autocapitalize(),

                        TextInput::make('isbn')
                            ->label('ISBN')
                            ->minLength(13),


                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('library_id')
                            ->relationship('library', 'name')
                            ->searchable()
                            ->default(fn() => Filament::auth()->user()->library_id)
                            ->preload()
                            ->disabled()
                            ->dehydrated(),

                        TextInput::make('author'),
                        TextInput::make('publisher'),
                        TextInput::make('pages')
                            ->label('Total Pages'),

                        DatePicker::make('publication_date')
                            ->date(),

                        Forms\Components\TextInput::make('stock')
                            ->label('Current Stock')
                            ->minLength(1),

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
                                    ->content(fn ($record) => $record?->borrowings()?->count() ?? 0)
                                    ->disabled(),

                                Forms\Components\Placeholder::make('total_likes')
                                    ->label('Total Likes')
                                    ->content(fn ($record) => $record?->likes()?->count() ?? 0)
                                    ->disabled(),

                                Forms\Components\Placeholder::make('total_reviews')
                                    ->label('Total Comments')
                                    ->content(fn ($record) => $record?->bookComents()?->count() ?? 0)
                                    ->disabled(),
                            ])
                    ])->columnSpan(['lg' => 1])
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function() {
                $librarian = Filament::auth()->user();

                return Book::query()
                    ->where('library_id', $librarian->library_id);
            })
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
                    ->limit(30)
                    ->extraAttributes([
                        'class' => 'capitalize'
                    ]),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category'),

                Tables\Columns\TextColumn::make('publication_date')
                    ->label('Publication Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable(),

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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
