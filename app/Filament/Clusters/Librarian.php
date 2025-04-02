<?php

namespace App\Filament\Clusters;

use App\Filament\Clusters\Librarian\Resources\LibrarianResource;
use Filament\Clusters\Cluster;

class Librarian extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = "Users Management";

    protected static ?string $navigationLabel = "Librarians";

    protected static ?string $clusterBreadcrumb = "Librarians";

    public static function getResources(): array
    {
        return [
            LibrarianResource::class,
        ];
    }

}
