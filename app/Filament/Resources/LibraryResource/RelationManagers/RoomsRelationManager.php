<?php

namespace App\Filament\Resources\LibraryResource\RelationManagers;

use App\Filament\Resources\RoomResource;
use App\Models\RoomBooking;
use App\Models\RoomCategory;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RoomsRelationManager extends RelationManager
{
    protected static string $relationship = 'rooms';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('price')
                    ->mask(RawJs::make(<<<'JS'
                        text => {
                            let number = text.replace(/[^\d]/g, '');
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                            currency: 'IDR',
                                            minimumFractionDigits: 0
                                }).format(number);
                            }
                        JS))
                    ->stripCharacters(',')
                    ->numeric(),
                Select::make('room_category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Repeater::make('facilities')
                    ->relationship('facilities')
                    ->schema([
                        TextInput::make('facility')
                            ->required(),
                        TextInput::make('description'),
                    ])
                    ->grid(['lg' => 2])
                    ->columnSpan(2)

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                SpatieMediaLibraryImageColumn::make('room')
                    ->label('Picture')
                    ->collection('room')
                    ->height(50)
                    ->width(50),

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

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'booked' => 'warning',
                        'available' => 'success',
                        'maintenance' => 'danger',
                    })
                    ->extraAttributes([
                        'class' => 'capitalize'
                    ]),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'booked' => 'Booked',
                        'maintenance' => 'Maintenance',
                    ]),

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
                    ->url(fn ($record): string => RoomResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
