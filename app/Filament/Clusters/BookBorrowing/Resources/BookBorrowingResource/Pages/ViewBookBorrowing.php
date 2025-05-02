<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource;
use App\Mail\LibrarianReportMail;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;

class ViewBookBorrowing extends ViewRecord
{
    protected static string $resource = BookBorrowingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

//            Actions\Action::make('changeStatus')
//                ->label('Change borrow status')
//                ->modalHeading('Change Borrow Status')
//                ->form([
//                    Select::make('status')
//                        ->label('Status Baru')
//                        ->options([
//                            'returned' => 'Returned',
//                            'penalty' => 'Penalty',
//                        ])
//                        ->required(),
//                ])
//                ->action(function (array $data, $record): void {
//                    $record->status = $data['status'];
//                    $record->save();
//
//                    if ($data['status'] === 'returned') {
//                        $record->book->increment('stock');
//                    }
//
//                })
//                ->color('primary')
//                ->icon('heroicon-m-pencil-square')
//                ->requiresConfirmation()
//                ->visible(fn ($record) => $record->status === 'borrowed'),

            Actions\Action::make('Send Email')
                ->label('Send Email Report')
                ->form([
                    Select::make('mail_type')
                        ->label('Mail Type')
                        ->options([
                            'borrowed_book_penalty' => 'Borrowed Book Penalty',
                            'booking_room_penalty' => 'Booking Room Penalty',
                            'custom' => 'Custom',
                        ])
                        ->default('borrowed_book_penalty')
                        ->reactive(),

                    TextInput::make('custom_mail_type')
                        ->label('Custom Mail Type')
                        ->visible(fn (Get $get) => $get('mail_type') === 'custom')
                        ->placeholder('For example: Reprimand, Data Request...')
                        ->required(fn (Get $get) => $get('mail_type') === 'custom'),

                    Textarea::make('message')
                        ->label('Message')
                        ->required()
                        ->rows(5),
                ])
                ->action(function (array $data) {
                    $member = $this->record->member;
                    $email     = $member->email;

                    $mailTypeLabel = match ($data['mail_type']) {
                        'borrowed_book_penalty' => 'Borrowed Book Penalty',
                        'booking_room_penalty' => 'Booking Room Penalty',
                        'custom' => $data['custom_mail_type'] ?? 'Custom',
                    };

                    $details = [
                        'mail_type'      => $mailTypeLabel,
                        'message'        => $data['message'],
                        'recipient_name' => $member->profile->first_name . ' ' . $member->profile->last_name,
                    ];

                    Mail::to($email)->send(new LibrarianReportMail($details));

                    Notification::make()
                        ->success()
                        ->title('Email Sending Successfully')
                        ->body('Message "' . $mailTypeLabel . '" Successfully sent to ' . $email)
                        ->send();
                })
                ->modalHeading('Send Email To '. $this->record->member->profile->first_name . " " . $this->record->member->profile->last_name)
                ->modalButton('Send'),
        ];
    }

    public function getTitle(): string
    {
        return $this->record->book->title;
    }
}
