<?php

namespace App\Filament\Clusters\Librarian\Resources\LibrarianResource\Pages;

use App\Filament\Clusters\Librarian\Resources\LibrarianResource;
use App\Mail\LibrarianReportMail;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;


class ViewLibrarian extends ViewRecord
{
    protected static string $resource = LibrarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('Send Email')
                ->label('Send Email To '. $this->record->profile->first_name . " " . $this->record->profile->last_name)
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
                    $librarian = $this->record;
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
                ->modalHeading('Send Email To '. $this->record->profile->first_name . " " . $this->record->profile->last_name)
                ->modalButton('Send'),
        ];
    }

    public function getTitle(): string
    {
        return $this->record->profile->first_name . ' ' .  $this->record->profile->last_name ;
    }
}
