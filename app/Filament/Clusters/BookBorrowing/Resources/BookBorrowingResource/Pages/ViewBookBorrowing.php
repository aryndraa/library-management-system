<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBookBorrowing extends ViewRecord
{
    protected static string $resource = BookBorrowingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
