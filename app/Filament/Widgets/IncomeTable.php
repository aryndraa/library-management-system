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
                    ->withSum('roomBookings as total_income', 'total_price')
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
                    ->sortable()
                    ->default(fn ($record) => $record->total_income ?? 0),
            ]);
    }
}
