<?php

namespace App\Filament\Clusters\Category\Resources\RoomCategoryResource\Pages;

use App\Filament\Clusters\Category\Resources\RoomCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoomCategory extends EditRecord
{
    protected static string $resource = RoomCategoryResource::class;

    public function getTitle(): string
    {
        return 'Edit ' . $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
