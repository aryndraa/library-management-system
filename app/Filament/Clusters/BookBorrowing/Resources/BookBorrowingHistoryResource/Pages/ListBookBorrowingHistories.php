<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingHistoryResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookBorrowingHistories extends ListRecords
{
    protected static string $resource = BookBorrowingHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
