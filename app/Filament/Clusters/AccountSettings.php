<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class AccountSettings extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
