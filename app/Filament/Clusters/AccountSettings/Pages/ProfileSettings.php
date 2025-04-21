<?php

namespace App\Filament\Clusters\AccountSettings\Pages;

use App\Filament\Clusters\AccountSettings;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('picture')
                            ->collection('librarian')
                            ->columnSpan(1),

                        Select::make('library_id')
                            ->relationship('library', 'name')
                            ->disabled()
                    ])
                    ->columnSpan(1),



            ])
            ->columns(3)
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
