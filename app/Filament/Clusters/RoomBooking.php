<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;
use Filament\Facades\Filament;

class RoomBooking extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationGroup = "Room Management";

    protected static ?string $navigationLabel = "Room Booking";

    protected static ?string $clusterBreadcrumb = "Room Booking";

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'librarian';
    }
}
