<?php

namespace App\Filament\Clusters\RoomBooking\Resources\RoomBookingResource\Pages;

use App\Filament\Clusters\RoomBooking\Resources\RoomBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRoomBooking extends ViewRecord
{
    protected static string $resource = RoomBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->record->room->name;
    }
}
