<?php

namespace App\Filament\Clusters\Librarian\Resources\LibrarianAbsentReportResource\Pages;

use App\Filament\Clusters\Librarian\Resources\LibrarianAbsentReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLibrarianAbsentReport extends EditRecord
{
    protected static string $resource = LibrarianAbsentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
