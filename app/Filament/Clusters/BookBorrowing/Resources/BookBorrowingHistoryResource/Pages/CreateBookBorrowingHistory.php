<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingHistoryResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookBorrowingHistory extends CreateRecord
{
    protected static string $resource = BookBorrowingHistoryResource::class;
}
