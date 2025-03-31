<?php

namespace App\Filament\Resources\LibraryResource\Pages;

use App\Filament\Resources\LibraryResource;
use App\Models\Library;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLibrary extends ViewRecord
{
    protected static string $resource = LibraryResource::class;

    public function getTitle(): string
    {
        return $this->record->name;
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
