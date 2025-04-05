<?php

namespace App\Filament\Clusters\Librarian\Resources\LibrarianResource\Pages;

use App\Filament\Clusters\Librarian\Resources\LibrarianResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;


class ViewLibrarian extends ViewRecord
{
    protected static string $resource = LibrarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->record->profile->first_name . ' ' .  $this->record->profile->last_name ;
    }
}
