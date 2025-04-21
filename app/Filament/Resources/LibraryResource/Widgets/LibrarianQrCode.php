<?php

namespace App\Filament\Resources\LibraryResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LibrarianQrCode extends Widget
{
    protected static string $view = 'filament.resources.library-resource.widgets.librarian-qr-code';

    public ?Model $record = null;

    protected function getQrCode(): string
    {
        return QrCode::size(200)->generate('http://library-app.test/librarian/presence/' . $this->record->id);
    }
}
