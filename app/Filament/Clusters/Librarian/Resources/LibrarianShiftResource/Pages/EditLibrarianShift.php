<?php

namespace App\Filament\Clusters\Librarian\Resources\LibrarianShiftResource\Pages;

use App\Filament\Clusters\Librarian\Resources\LibrarianShiftResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLibrarianShift extends EditRecord
{
    protected static string $resource = LibrarianShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
