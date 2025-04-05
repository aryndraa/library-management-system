<?php

namespace App\Filament\Resources\MemberResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
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
                Group::make()
                    ->relationship('room')
                    ->schema([
                        TextInput::make('name')
                            ->label('Room Name')
                            ->required()
                            ->columnSpan(2),

                        Group::make()
                            ->relationship('category')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Room Category')
                            ]),

                        TextInput::make('price')
                            ->label('Price')
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


                        Repeater::make('room_facilities_id')
                            ->relationship('facilities')
                            ->schema([
                                TextInput::make('facility')
                            ])
                            ->columnSpan(2)
                            ->grid(['lg' => 2])
                    ])
                    ->columns(2)
                    ->columnSpan(2),

                Forms\Components\Section::make()
                    ->schema([
                        DatePicker::make('booking_date')
                            ->date(),

                        TimePicker::make('started_time'),
                        TimePicker::make('finished_time'),
                        TextInput::make('total_price')
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
                            ->numeric()

                    ])
                ->columnSpan(1)
            ])
            ->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('room_name')
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
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}

