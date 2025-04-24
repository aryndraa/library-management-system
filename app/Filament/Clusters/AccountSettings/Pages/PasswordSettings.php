<?php

namespace App\Filament\Clusters\AccountSettings\Pages;

use App\Filament\Clusters\AccountSettings;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;

class PasswordSettings extends Page
{


    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static string $view = 'filament.clusters.account-settings.pages.password-settings';

    protected static ?string $cluster = AccountSettings::class;

    protected static ?int $navigationSort = 3;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            auth()->user()->attributesToArray()
        );

    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('password')
                    ->label('Current Password')
                    ->password()
                    ->required(),

                TextInput::make('new_password')
                    ->label('New Password')
                    ->password()
                    ->required()
                    ->confirmed(),

                TextInput::make('new_password_confirmation')
                    ->label('Confirm New Password')
                    ->password()
                    ->required(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('Update')
                ->color('primary')
                ->submit('Update'),
        ];
    }

    public function update()
    {
        $data = $this->form->getState();

        if (!Hash::check($data['password'], auth()->user()->password)) {
            Notification::make()
                ->title('The current password is incorrect.')
                ->danger()
                ->send();

            return;
        }

        auth()->user()->update([
            'password' => 'new_password',
        ]);

        Notification::make()
            ->title('Password updated successfully!')
            ->success()
            ->send();

        $this->form->fill([]);
    }

}
