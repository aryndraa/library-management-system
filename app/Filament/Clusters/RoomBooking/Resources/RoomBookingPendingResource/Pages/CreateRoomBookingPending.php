<?php

namespace App\Filament\Clusters\RoomBooking\Resources\RoomBookingPendingResource\Pages;

use App\Filament\Clusters\RoomBooking\Resources\RoomBookingPendingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRoomBookingPending extends CreateRecord
{
    protected static string $resource = RoomBookingPendingResource::class;
}
