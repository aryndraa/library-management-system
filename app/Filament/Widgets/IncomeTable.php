<?php

namespace App\Filament\Widgets;

use App\Models\Library;
use App\Models\Room;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class IncomeTable extends BaseWidget
{

    protected static ?int $sort = 4;


    public function table(Table $table): Table
    {
        return $table
            ->query(
                Library::query()
                    ->with(['rooms.bookings'])
                    ->withCount('rooms as total_rooms')
                    ->selectRaw('libraries.*, (SELECT SUM(rooms.price * (SELECT COUNT(*) FROM room_bookings WHERE room_bookings.room_id = rooms.id)) FROM rooms WHERE rooms.library_id = libraries.id) as total_income')
            )
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Library Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_rooms')
                    ->label('Total Rooms')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_income')
                    ->label('Total Income')
                    ->money('USD')
                    ->sortable(),
            ]);
    }
}
