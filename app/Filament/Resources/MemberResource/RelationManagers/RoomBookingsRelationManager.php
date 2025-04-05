<?php

namespace App\Filament\Resources\MemberResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomBookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'roomBookings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('room.name')
            ->columns([
                Tables\Columns\TextColumn::make('room.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('room.library.name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('room.category.name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('booking_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable(),

            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('room.category', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Category'),

                Tables\Filters\SelectFilter::make('library')
                    ->relationship('room.library', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Library'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
