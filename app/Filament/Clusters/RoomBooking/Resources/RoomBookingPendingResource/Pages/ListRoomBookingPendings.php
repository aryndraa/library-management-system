<?php

namespace App\Filament\Clusters\RoomBooking\Resources\RoomBookingPendingResource\Pages;

use App\Filament\Clusters\RoomBooking\Resources\RoomBookingPendingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoomBookingPendings extends ListRecords
{
    protected static string $resource = RoomBookingPendingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
