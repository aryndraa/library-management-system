<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookBorrowing extends CreateRecord
{
    protected static string $resource = BookBorrowingResource::class;
}
