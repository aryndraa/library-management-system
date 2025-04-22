<?php

namespace App\Filament\Librarian\Pages;

use App\Models\RoomBooking;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingReceipt extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.librarian.pages.booking-receipt';

    protected static ?string $navigationGroup = 'Room Management';

    protected static ?int $navigationSort= 3;

    public ?string $code = '';

    public $roomBooking;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Enter code to get room booking receipt')
                    ->placeholder('Enter Code')
                    ->required(),

            ]);
    }


    public function searchRoomBooking()
    {
        $this->validateOnly('code', [
            'code' => 'required|string',
        ]);

        $this->roomBooking = RoomBooking::query()
            ->where('code', $this->code)
            ->whereHas('room', function ($query) {
                $query->where('library_id', Filament::auth()->user()->library_id);
            })
            ->first();

        if (! $this->roomBooking) {
            Notification::make()
                ->title('Room Booking receipt not found.')
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title('Room Booking receipt found!')
            ->success()
            ->send();
    }

    public function printPdf(): StreamedResponse
    {
        if (! $this->roomBooking) {
            Notification::make()
                ->title('No room booking record to print.')
                ->danger()
                ->send();

            return back();
        }

        $pdf = Pdf::loadView('exports.booking-receipt', [
            'roomBooking' => $this->roomBooking,
        ]);

        Notification::make()
            ->title('Receipt print!')
            ->success()
            ->send();

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'borrowing-receipt.pdf');
    }

}
