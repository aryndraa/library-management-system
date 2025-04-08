<?php

namespace App\Filament\Clusters\RoomBooking\Resources\RoomBookingResource\Pages;

use App\Filament\Clusters\RoomBooking\Resources\RoomBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoomBookings extends ListRecords
{
    protected static string $resource = RoomBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
