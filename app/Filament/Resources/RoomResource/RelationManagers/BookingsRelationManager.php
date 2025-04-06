<?php

namespace App\Filament\Resources\RoomResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    protected static ?string $title = 'Member Bookings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('room_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('room.name')
            ->columns([
                Tables\Columns\TextColumn::make('member..profile.first_name')
                    ->getStateUsing(function ($record) {
                        return $record->member->profile->first_name . ' ' . $record->member->profile->last_name;
                    })
                        ->label('Member')
                        ->sortable()
                        ->searchable(),

                Tables\Columns\TextColumn::make('booking_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('started_time')
                    ->time()
                    ->sortable(),

                Tables\Columns\TextColumn::make('finished_time')
                    ->time(),

                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'check out' => 'gray',
                        'check in' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                    })
            ])
            ->filters([
                //
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
