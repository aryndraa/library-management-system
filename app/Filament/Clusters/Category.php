<?php

namespace App\Filament\Clusters;

use App\Filament\Clusters\Category\Resources\BookCategoryResource;
use Filament\Clusters\Cluster;

class Category extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    protected static ?string $navigationGroup = "Resources";

    protected static ?string $navigationLabel = "Categories";

    protected static ?string $clusterBreadcrumb = "Categories";

    public static function getResources(): array
    {
        return [
            BookCategoryResource::class,
        ];
    }
}
