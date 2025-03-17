<?php

namespace App\Filament\Resources\LibraryScheduleResource\Pages;

use App\Filament\Resources\LibraryScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLibrarySchedule extends EditRecord
{
    protected static string $resource = LibraryScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
