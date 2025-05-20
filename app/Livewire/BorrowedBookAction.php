<?php

namespace App\Livewire;

use App\Models\BorrowedBook;
use Livewire\Component;

class BorrowedBookAction extends Component
{
    public $borrowedId;

    public function mount($borrowedId)
    {
        $this->borrowedId = $borrowedId;
    }

    public function returnBook()
    {
        $borrowed = BorrowedBook::query()
            ->where('id', $this->borrowedId)
            ->first();

        if ($borrowed->status !== 'return requested') {
            $borrowed->status = 'return requested';
            $borrowed->save();

            flash()->success('Return request send successfully');

            $this->dispatch('close-modal', id: $this->borrowedId);
        }
    }

    public function render()
    {
        return view('livewire.borrowed-book-action');
    }
}
