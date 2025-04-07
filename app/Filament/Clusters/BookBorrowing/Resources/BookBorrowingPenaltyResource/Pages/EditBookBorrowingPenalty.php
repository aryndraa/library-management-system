<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingPenaltyResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingPenaltyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookBorrowingPenalty extends EditRecord
{
    protected static string $resource = BookBorrowingPenaltyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
