<?php

namespace App\Filament\Librarian\Pages;

use App\Models\Library;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class LibraryDetail extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.librarian.pages.library-detail';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }


    public ?Library $library = null;

    public function mount(): void
    {
        $this->library = Library::find(auth()->user()->library_id);

        $this->form->fill(
            $this->library->toArray()
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->relationship('library')
                    ->schema([
                        TextInput::make('name'),

                        SpatieMediaLibraryFileUpload::make('picture')
                            ->collection('library')
                            ->image()
                            ->disabled() // jika hanya ingin preview
                    ])
            ])
            ->statePath('data')
            ->model(auth()->user());
    }




}
