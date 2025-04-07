<?php

namespace App\Filament\Resources\LibraryResource\RelationManagers;

use App\Filament\Resources\BookResource;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('isbn')
                    ->required()
                    ->unique()
                    ->maxLength(13),
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
                    ->date(),
                Textarea::make('synopsis')
                    ->label('Description')
                    ->columnSpan(2)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                SpatieMediaLibraryImageColumn::make('cover')
                    ->label('Cover')
                    ->collection('book')
                    ->height(50)
                    ->width(50),

                TextColumn::make('isbn')
                    ->sortable(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                TextColumn::make('category.name')
                    ->sortable(),
                TextColumn::make('stock')
                    ->sortable(),
                TextColumn::make('publication_date')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->attribute('category.name'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->url(fn ($record): string => BookResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

}
