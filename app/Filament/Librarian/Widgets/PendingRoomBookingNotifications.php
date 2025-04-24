<?php

namespace App\Filament\Librarian\Widgets;

use App\Models\RoomBooking;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingRoomBookingNotifications extends BaseWidget
{

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                RoomBooking::query()
                    ->whereHas('room', function ($query) {
                        $query->where('library_id', auth()->user()->library_id);
                    })
                    ->where('status', 'pending')
                    ->orderByDesc('created_at')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('member.first_name')
                    ->getStateUsing(fn ($record) =>
                        $record->member->profile->first_name .
                        ' '
                        . $record->member->profile->last_name
                    ),

                Tables\Columns\TextColumn::make('room.name'),

                TextColumn::make('booking_date')
                    ->dateTime('d M')
                    ->label('Date'),

                Tables\Columns\TextColumn::make('started_time')
                    ->label('Time')
                    ->getStateUsing(fn ($record) => $record->started_time . ' - ' . $record->finished_time )

            ])
            ->paginated(false);
    }
}
