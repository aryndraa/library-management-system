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
            Actions\Action::make('Send Email')
                ->label('Send Email To '. $this->record->librarian->profile->first_name . " " . $this->record->librarian->profile->last_name)
                ->form([
                    Select::make('mail_type')
                        ->label('Mail Type')
                        ->options([
                            'absent_report' => 'Absent Report',
                            'reminder' => 'Reminder',
                            'custom' => 'Custom',
                        ])
                        ->default('absent_report')
                        ->reactive(),

                    TextInput::make('custom_mail_type')
                        ->label('Custom Mail Type')
                        ->visible(fn (Get $get) => $get('mail_type') === 'custom')
                        ->placeholder('For example: Reprimand, Data Request...')
                        ->required(fn (Get $get) => $get('mail_type') === 'custom'),

                    Textarea::make('message')
                        ->label('Pesan')
                        ->required()
                        ->rows(5),
                ])
                ->action(function (array $data) {
                    $librarian = $this->record->librarian;
                    $email     = $librarian->email;

                    $mailTypeLabel = match ($data['mail_type']) {
                        'absent_report' => 'Absent Report',
                        'reminder' => 'Reminder',
                        'custom' => $data['custom_mail_type'] ?? 'Custom',
                    };

                    $details = [
                        'mail_type'      => $mailTypeLabel,
                        'message'        => $data['message'],
                        'recipient_name' => $librarian->profile->first_name . ' ' . $librarian->profile->last_name,
                    ];

                    Mail::to($email)->send(new LibrarianReportMail($details));

                    Notification::make()
                        ->success()
                        ->title('Email Sending Successfully')
                        ->body('Message "' . $mailTypeLabel . '" Successfully sent to ' . $email)
                        ->send();
                })
                ->modalHeading('Send Email To '. $this->record->librarian->profile->first_name . " " . $this->record->librarian->profile->last_name)
                ->modalButton('Send'),
        ];
    }

    public function getTitle(): string
    {
        return $this->record->librarian->profile->first_name . " " . $this->record->librarian->profile->last_name;
    }
}
