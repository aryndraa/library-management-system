<?php

namespace App\Filament\Clusters\Category\Resources\BookCategoryResource\Pages;

use App\Filament\Clusters\Category\Resources\BookCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookCategory extends EditRecord
{
    protected static string $resource = BookCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Edit ' . $this->record->name;
    }
}
