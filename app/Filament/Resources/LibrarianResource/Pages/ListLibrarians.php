<?php

namespace App\Filament\Resources\LibrarianResource\Pages;

use App\Filament\Resources\LibrarianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLibrarians extends ListRecords
{
    protected static string $resource = LibrarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
