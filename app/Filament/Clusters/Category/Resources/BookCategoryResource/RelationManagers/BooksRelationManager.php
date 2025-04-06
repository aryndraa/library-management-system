<?php

namespace App\Filament\Clusters\Category\Resources\BookCategoryResource\RelationManagers;

use App\Filament\Resources\BookResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('isbn')
                    ->sortable()
                    ->label('ISBN')
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('library.name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->sortable(),

                TextColumn::make('publication_date')
                    ->label('Publication Date')
                    ->date()
                    ->searchable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('library')
                    ->relationship('library', 'name')
                    ->preload()
                    ->searchable()

            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->url(fn ($record): string => BookResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye')
            ])
            ->bulkActions([
            ]);
    }
}
