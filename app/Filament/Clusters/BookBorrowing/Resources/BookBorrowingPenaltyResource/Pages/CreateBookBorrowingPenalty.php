<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingPenaltyResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingPenaltyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookBorrowingPenalty extends CreateRecord
{
    protected static string $resource = BookBorrowingPenaltyResource::class;
}
