<?php

namespace App\Filament\Clusters\Librarian\Resources\LibrarianAbsentReportResource\Pages;

use     App\Filament\Clusters\Librarian\Resources\LibrarianAbsentReportResource;
use App\Mail\LibrarianReportMail;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class ViewLibrarianAbsentReport extends ViewRecord
{
    protected static string $resource = LibrarianAbsentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    public function getTitle(): string
    {
        return $this->record->librarian->profile->first_name . " " . $this->record->librarian->profile->last_name;
    }
}
