<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\LibraryResource;
use App\Filament\Resources\LibraryResource\Pages\ViewLibrary;
use App\Models\Library;
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
                    ->money('IDR')
                    ->sortable()
                    ->default(fn ($record) => $record->total_income ?? 0),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->url(fn ($record): string => LibraryResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye')
            ]);
    }

    public static function getPages(): array
    {
        return [
            'view' => ViewLibrary::route('/{recorde}'),
        ];
    }

}
