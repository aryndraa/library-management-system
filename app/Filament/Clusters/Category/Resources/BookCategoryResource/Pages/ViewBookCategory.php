<?php

namespace App\Filament\Clusters\Category\Resources\BookCategoryResource\Pages;

use App\Filament\Clusters\Category\Resources\BookCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBookCategory extends ViewRecord
{
    protected static string $resource = BookCategoryResource::class;

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
