<?php

namespace App\Filament\Clusters;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource;
use Filament\Clusters\Cluster;
use Filament\Facades\Filament;

class BookBorrowing extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationGroup = "Book Management";

    protected static ?string $navigationLabel = "Book Borrowing";

    protected static ?string $clusterBreadcrumb = "Book Borrowing";

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'librarian';
    }

    public static function getResources(): array
    {
        return [
            BookBorrowingResource::class,
        ];
    }
}
