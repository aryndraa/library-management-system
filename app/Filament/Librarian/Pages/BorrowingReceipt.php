<?php

namespace App\Filament\Librarian\Pages;

use App\Models\BorrowedBook;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class BorrowingReceipt extends Page implements HasForms
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.librarian.pages.borrowing-receipt';

    protected static ?string $navigationGroup = "Book Management";

    protected static ?int $navigationSort = 3;

    public ?string $code = '';


    public $borrowedBook;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Enter code to get borrowing receipt')
                    ->placeholder('Enter Code')
                    ->required()
            ]);
    }

    public function searchBorrowedBook()
    {
        $this->validateOnly('code', [
            'code' => 'required|string',
        ]);

        $this->borrowedBook = BorrowedBook::query()
            ->where('code', $this->code)
            ->where('library_id', Filament::auth()->user()->library_id)
            ->first();

        if (! $this->borrowedBook) {
            Notification::make()
                ->title('Borrowing receipt not found.')
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title('Borrowing receipt found!')
            ->success()
            ->send();
    }



}
