<?php

namespace App\Filament\Librarian\Resources\RoomResource\Pages;

use App\Filament\Librarian\Resources\RoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Str;

class ViewRoom extends ViewRecord
{
    protected static string $resource = RoomResource::class;

    public function getTitle(): string
    {
        return Str::title($this->record->name);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
