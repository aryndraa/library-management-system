<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingReturnRequestedResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingReturnRequestedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookBorrowingReturnRequested extends CreateRecord
{
    protected static string $resource = BookBorrowingReturnRequestedResource::class;
}
