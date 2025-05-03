<?php

namespace App\Filament\Librarian\Pages;

use Filament\Pages\Page;

class BookingReceipt extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.librarian.pages.booking-receipt';

    protected static ?string $navigationGroup = 'Room Management';

    protected static ?int $navigationSort= 3;


}
