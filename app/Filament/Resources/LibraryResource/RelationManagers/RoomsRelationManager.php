<?php

namespace App\Filament\Resources\LibraryResource\RelationManagers;

use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\RoomCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomsRelationManager extends RelationManager
{
    protected static string $relationship = 'rooms';

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
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Room Category')
                    ->getStateUsing(function ($record) {
                        return RoomCategory::query()->where('id', $record->room_category_id)->first()->name;
                    }),
                TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Total Income')
                    ->getStateUsing(function ($record) {
                        return RoomBooking::query()->where('room_id', $record->id)->sum('total_price');
                    })
                    ->money('USD')
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
