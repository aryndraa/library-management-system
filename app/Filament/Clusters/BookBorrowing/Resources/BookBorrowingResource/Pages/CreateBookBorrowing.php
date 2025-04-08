<?php

namespace App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource\Pages;

use App\Filament\Clusters\BookBorrowing\Resources\BookBorrowingResource;
use App\Filament\Resources\BookResource;
use App\Models\Book;
use App\Models\Room;
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

                Hidden::make('library_id')
                    ->default(
                        Filament::auth()->user()->library_id
                    ),

                TextInput::make('code')
                    ->minLength(6)
                    ->default(strtoupper(Str::random(6)))
                    ->dehydrated(),

                ToggleButtons::make('status')
                    ->inline()
                    ->options([
                        'borrowed' => 'Borrowed',
                        'returned' => 'Returned',
                        'penalty'  => 'Penalty',
                    ])
                    ->colors([
                        'borrowed' => 'warning',
                        'returned' => 'success',
                        'penalty'  => 'danger',
                    ])
                    ->required()
                    ->required(),

                Group::make()
                    ->schema([
                        DatePicker::make('borrowed_date')
                            ->label('Borrowed Date')
                            ->date()
                            ->required(),

                        DatePicker::make('due_date')
                            ->label('Due Date')
                            ->date()
                            ->required(),
                    ])
                    ->columns(2),

                DatePicker::make('returned_date')
                    ->label('Returned Date')
                    ->date()
                    ->nullable(),
            ]);

    }

    protected function afterCreate(): void
    {
        $book = $this->record->book;

        if ($book && $book->stock > 0) {
            $book->decrement('stock');
        }
    }}
