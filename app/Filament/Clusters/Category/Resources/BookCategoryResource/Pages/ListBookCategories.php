<?php

namespace App\Filament\Clusters\Category\Resources\BookCategoryResource\Pages;

use App\Filament\Clusters\Category\Resources\BookCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookCategories extends ListRecords
{
    protected static string $resource = BookCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
