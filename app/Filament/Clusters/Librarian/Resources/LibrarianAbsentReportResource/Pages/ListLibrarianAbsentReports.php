<?php

namespace App\Filament\Clusters\Librarian\Resources\LibrarianAbsentReportResource\Pages;

use App\Filament\Clusters\Librarian\Resources\LibrarianAbsentReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLibrarianAbsentReports extends ListRecords
{
    protected static string $resource = LibrarianAbsentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
