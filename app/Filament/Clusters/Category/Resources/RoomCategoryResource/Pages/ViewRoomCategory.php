<?php

namespace App\Filament\Clusters\Category\Resources\RoomCategoryResource\Pages;

use App\Filament\Clusters\Category\Resources\RoomCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRoomCategory extends ViewRecord
{
    protected static string $resource = RoomCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->record->name;
    }
}
