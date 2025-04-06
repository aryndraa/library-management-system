<?php

namespace App\Filament\Clusters\Category\Resources\RoomCategoryResource\Pages;

use App\Filament\Clusters\Category\Resources\RoomCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoomCategories extends ListRecords
{
    protected static string $resource = RoomCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
