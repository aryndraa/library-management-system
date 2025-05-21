<?php

namespace App\Filament\Clusters\Category\Resources;

use App\Filament\Clusters\Category;
use App\Filament\Clusters\Category\Resources\BookCategoryResource\Pages;
use App\Filament\Clusters\Category\Resources\BookCategoryResource\RelationManagers;
use App\Models\BookCategory;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookCategoryResource extends Resource
{
    protected static ?string $model = \App\Models\Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $label = "Book Categories";

    protected static ?string $cluster = Category::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([

                        TextInput::make('name')
                            ->label('Name')
                            ->string()
                            ->required()
                            ->unique('categories', 'name')
                            ->autocapitalize(),

                        TextInput::make('code')
                            ->label('Code')
                            ->minLength(4)
                            ->unique('categories', 'code', null, true)
                    ])->columnSpan(1),

                    SpatieMediaLibraryFileUpload::make('cover')
                        ->collection('book')
                        ->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('code')
                    ->label('Code')
                    ->sortable()
                    ->searchable(),

                TextColumn::make("books_count")
                    ->label('Total Books')
                    ->counts('books')
                    ->sortable(),

            ])
            ->filters([
                //
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
            RelationManagers\BooksRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookCategories::route('/'),
            'create' => Pages\CreateBookCategory::route('/create'),
            'view' => Pages\ViewBookCategory::route('/{record}'),
            'edit' => Pages\EditBookCategory::route('/{record}/edit'),
        ];
    }
}
