<?php

namespace App\Filament\Clusters;

use App\Filament\Clusters\Category\Resources\BookCategoryResource;
use Filament\Clusters\Cluster;
use Filament\Facades\Filament;

class Category extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    protected static ?string $navigationGroup = "Resources";

    protected static ?string $navigationLabel = "Categories";

    protected static ?string $clusterBreadcrumb = "Categories";

    /**
     * @param bool $shouldRegisterNavigation
     */
    public static function shouldRegisterNavigation(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'admin';
    }

    public static function getResources(): array
    {
        return [
            BookCategoryResource::class,
        ];
    }
}
