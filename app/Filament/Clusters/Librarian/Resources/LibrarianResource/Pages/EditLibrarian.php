<?php

namespace App\Filament\Clusters\Librarian\Resources\LibrarianResource\Pages;

use App\Filament\Clusters\Librarian\Resources\LibrarianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLibrarian extends EditRecord
{
    protected static string $resource = LibrarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->record->profile->first_name . ' ' .  $this->record->profile->last_name ;
    }
}
