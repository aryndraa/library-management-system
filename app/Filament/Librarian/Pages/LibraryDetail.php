<?php

namespace App\Filament\Librarian\Pages;

use App\Models\Librarian;
use App\Models\Library;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
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
use Filament\Tables\Filters\SelectFilter;
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

    public ?array $data = [];

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
                TextInput::make('email'),
                TextInput::make('phone'),
                Group::make()
                    ->schema([
                        Placeholder::make('total_books')
                            ->label('Total Books')
                            ->content(fn ($record) => $record?->books()->count() ?? 0)
                            ->disabled(),

                        Placeholder::make('total_librarians')
                            ->label('Total Librarians')
                            ->content(fn ($record) => $record?->librarians()->count() ?? 0)
                            ->disabled(),

                        Placeholder::make('total_rooms')
                            ->label('Total Rooms')
                            ->content(fn ($record) => $record?->rooms()->count() ?? 0)
                            ->disabled(),

                        Placeholder::make('total_visits')
                            ->label('Total Visits')
                            ->content(fn ($record) => $record?->memberVisits()->count() ?? 0)
                        ,

                        Placeholder::make('total_income')
                            ->label('Total Income')
                            ->content(function ($record) {
                                $total = 0;

                                if($record?->rooms) {
                                    foreach ($record->rooms as $room) {
                                        $total += $room->bookings?->sum('total_price');
                                    }
                                }

                                return 'Rp ' . number_format($total, 0, ',', '.');
                            })
                            ->disabled()
                            ->columnSpan(2),
                    ]),
            ])
            ->disabled()
            ->statePath('data')
            ->model($this->library);
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
                    ->label('Phone')

            ])
            ->paginated(false);
    }





}
