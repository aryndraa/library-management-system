<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookBorrowing extends EditRecord
{
    protected static string $resource = BookBorrowingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        if ($record->status === 'returned') {
            $book = $record->book;
            $book->increment('stock');
        }
    }
}
