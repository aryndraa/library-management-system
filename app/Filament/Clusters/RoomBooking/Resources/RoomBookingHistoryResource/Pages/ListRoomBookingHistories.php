<?php

namespace App\Filament\Clusters\RoomBooking\Resources\RoomBookingHistoryResource\Pages;

use App\Filament\Clusters\RoomBooking\Resources\RoomBookingHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoomBookingHistories extends ListRecords
{
    protected static string $resource = RoomBookingHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
