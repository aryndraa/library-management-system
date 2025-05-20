<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingReturnRequestedResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingReturnRequestedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookBorrowingReturnRequested extends EditRecord
{
    protected static string $resource = BookBorrowingReturnRequestedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $originalStatus = $this->record->status;

        if ($originalStatus !== 'returned' && $data['status'] === 'returned') {
            $book = $this->record->book;

            if ($book) {
                $book->increment('stock');
            }

            if (empty($data['returned_date'])) {
                $data['returned_date'] = now();
            }
        }

        return $data;
    }
}
