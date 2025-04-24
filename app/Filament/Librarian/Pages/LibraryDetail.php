<?php

namespace App\Filament\Librarian\Pages;

use Filament\Pages\Page;

class LibraryDetail extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.librarian.pages.library-detail';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
