<?php

namespace App\Filament\Librarian\Resources;

use App\Filament\Librarian\Resources\BookResource\Pages;
use App\Filament\Librarian\Resources\BookResource\RelationManagers;
use App\Models\Admin;
use App\Models\Book;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
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

    protected static ?string $recordTitleAttribute = 'title';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Book Detail')
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
                            ->label('Description')
                            ->autosize(),
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
                                    ->content(fn ($record) => $record?->bookComments()?->count() ?? 0)
                                    ->disabled(),
                            ])
                            ->columnSpan(2),
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
                    ->collection('book')
                    ->width(40)
                    ->height(60),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('isbn')
                    ->label('ISBN')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('author')
                    ->label('Author')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('category')
                    ->preload()
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records, Tables\Actions\DeleteBulkAction $action) {
                            foreach ($records as $record) {
                                if ($record->borrowings()->whereNot('status', 'returned')->exists()) {
                                    Notification::make()
                                        ->title('Buku tidak bisa dihapus')
                                        ->body('Masih ada peminjam yang belum mengembalikan buku ini.')
                                        ->danger()
                                        ->send();

                                    $action->cancel();
                                }

                                $admins = Admin::all();

                                foreach ($admins as $admin) {
                                    Notification::make()
                                        ->title('Book Deleted')
                                        ->icon('heroicon-o-trash')
                                        ->body("Book **{$record->title}** from library **{$record->library?->name}** has been deleted.")
                                        ->sendToDatabase($admin);
                                }
                            }
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BorrowingsRelationManager::class,
            RelationManagers\LikesRelationManager::class,
            RelationManagers\BookCommentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'view' => Pages\ViewBook::route('/{record}'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
