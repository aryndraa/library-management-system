<?php

namespace App\Filament\Clusters\Category\Resources\BookCategoryResource\Pages;

use App\Filament\Clusters\Category\Resources\BookCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookCategory extends CreateRecord
{
    protected static string $resource = BookCategoryResource::class;
}
