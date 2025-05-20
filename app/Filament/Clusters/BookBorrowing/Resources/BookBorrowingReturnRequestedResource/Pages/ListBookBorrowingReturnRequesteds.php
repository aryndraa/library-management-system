<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingReturnRequestedResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingReturnRequestedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookBorrowingReturnRequesteds extends ListRecords
{
    protected static string $resource = BookBorrowingReturnRequestedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
