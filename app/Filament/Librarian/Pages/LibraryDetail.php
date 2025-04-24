<?php

namespace App\Filament\Librarian\Pages;

use App\Models\Librarian;
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
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class LibraryDetail extends Page implements HasTable
{

    use InteractsWithTable;

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

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Librarian::query()->where('library_id', $this->library->id)
            )
            ->columns([
                SpatieMediaLibraryImageColumn::make('librarian')
                    ->label('Picture')
                    ->collection('librarian')
                    ->height(50)
                    ->width(50)
                    ->rounded(),

                TextColumn::make('profile.first_name')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->profile->first_name . ' ' . $record->profile->last_name;
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('profile.phone')

            ]);
    }





}
