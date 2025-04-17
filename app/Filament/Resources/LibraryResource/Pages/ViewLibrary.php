<?php

namespace App\Filament\Resources\LibraryResource\Pages;

use App\Filament\Resources\LibraryResource;
use Filament\Actions;
use Filament\Infolists\Components\View;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\ViewRecord;

class ViewLibrary extends ViewRecord
{
    use HasRelationManagers;


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
