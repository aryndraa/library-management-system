<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource;
use App\Filament\Resources\BookResource;
use App\Models\Book;
use App\Models\Room;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateBookBorrowing extends CreateRecord
{
    protected static string $resource = BookBorrowingResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('member_id')
                            ->label('Member')
                            ->relationship('member', 'email')
                            ->preload()
                            ->searchable()
                            ->required(),

                        Select::make('book_id')
                            ->label('Book')
                            ->options(function () {
                                $libraryId = Filament::auth()->user()->library_id;
                                return Book::query()
                                    ->where('library_id', $libraryId)
                                    ->where('stock', '!=', 0)
                                    ->pluck('title', 'id');
                            })
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->required(),

                        DatePicker::make('borrowed_date')
                            ->label('Borrowed Date')
                            ->date()
                            ->required()
                            ->columnSpan(2),

                    ])
                ->columns(2)
                ->columnSpan(2)
            ]);

    }

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = 'BRW-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));
        $data['library_id'] = Filament::auth()->user()->library_id;
        $data['due_date'] = Carbon::parse($data['borrowed_date'])->addDays(5);
        $data['status'] = 'pending';

        return $data;
    }

    protected function afterCreate(): void
    {
        $book = $this->record->book;

        if ($book && $book->stock > 0) {
            $book->decrement('stock');
        }
    }}
