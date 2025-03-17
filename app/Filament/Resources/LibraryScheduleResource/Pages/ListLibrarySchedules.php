<?php

namespace App\Filament\Resources\LibraryScheduleResource\Pages;

use App\Filament\Resources\LibraryScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLibrarySchedules extends ListRecords
{
    protected static string $resource = LibraryScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
