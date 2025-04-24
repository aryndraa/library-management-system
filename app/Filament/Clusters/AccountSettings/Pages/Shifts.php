<?php

namespace App\Filament\Clusters\AccountSettings\Pages;

use App\Filament\Clusters\AccountSettings;
use Filament\Pages\Page;

class Shifts extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';

    protected static string $view = 'filament.clusters.account-settings.pages.shifts';

    protected static ?string $cluster = AccountSettings::class;

    protected static ?int $navigationSort = 2;
}
