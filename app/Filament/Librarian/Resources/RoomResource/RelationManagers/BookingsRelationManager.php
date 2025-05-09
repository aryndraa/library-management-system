<?php

namespace App\Filament\Librarian\Resources\RoomResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('room.name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('room.name')
            ->columns([
                Tables\Columns\TextColumn::make('member.profile.first_name')
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
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'check out' => 'gray',
                        'check in' => 'success',
                        'pending' => 'warning',
                        'canceled' => 'danger',
                        'schedule' => 'primary',
                    })
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'check in' => 'Check In',
                        'check out'  => 'Check Out',
                        'schedule'  => 'Schedule',
                        'cancel' => 'Cancel',
                    ]),

                Tables\Filters\Filter::make('booking_date')
                    ->form([
                        DatePicker::make('booking_date')
                            ->label('Booking Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['booking_date'], fn ($query, $date) =>
                            $query->whereDate('booking_date', $date));
                    }),

            ])
            ->headerActions([
            ])
            ->actions([

            ])
            ->bulkActions([

            ]);
    }
}
