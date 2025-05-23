<?php

namespace App\Filament\Resources\LibraryResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberQrCode extends Widget
{
    protected static string $view = 'filament.resources.library-resource.widgets.member-qr-code';

    public ?Model $record = null;


    protected function getQrCode(): string
    {
        return QrCode::size(200)->generate('http://library-app.test/attendance/' . $this->record->id);
    }
}
