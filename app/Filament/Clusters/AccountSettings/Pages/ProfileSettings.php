<?php

namespace App\Filament\Clusters\AccountSettings\Pages;

use App\Filament\Clusters\AccountSettings;
use App\Filament\Clusters\AccountSettings\Resources\ProfileSettingsResource\Widgets\LibraryInfo;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class ProfileSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.clusters.account-settings.pages.profile-settings';

    protected static ?string $cluster = AccountSettings::class;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            auth()->user()->attributesToArray()
        );
    }

    protected function getHeaderWidgets(): array
    {
       return [
         LibraryInfo::class
       ];
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        group::make()
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('picture')
                                    ->collection('librarian')
                                    ->columnSpan(1)
                                    ->panelAspectRatio("1:1")
                                    ->previewable()
                                    ->image()
                            ])
                            ->columns(3)
                            ->columnSpan(2),

                        Group::make()
                            ->relationship('profile')
                            ->schema([
                                TextInput::make('first_name')
                                    ->required(),
                                TextInput::make('last_name')
                                    ->required(),
                                Select::make('gender')
                                    ->options([
                                        'male' => 'Male',
                                        'female' => 'Female',
                                    ])
                                    ->required(),
                                TextInput::make('address'),
                                TextInput::make('province'),
                                TextInput::make('city'),
                                DatePicker::make('birth_date'),
                            ])
                            ->columns(2),
                    ]),

                Section::make("Contact Information")
                    ->schema([
                        TextInput::make('email')
                            ->email()
                            ->required(),

                        Group::make()
                            ->relationship('profile')
                            ->schema([
                                TextInput::make('phone')
                                    ->required(),
                            ])
                    ])
                    ->columns(2)

            ])
            ->statePath('data')
            ->model(auth()->user());
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
        auth()->user()->update(
            $this->form->getState()
        );

        Notification::make()
            ->title('Profile updated!')
            ->success()
            ->send();
    }
}
