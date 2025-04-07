<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookBorrowings extends ListRecords
{
    protected static string $resource = BookBorrowingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
