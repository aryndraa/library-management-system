<?php

namespace App\Livewire;

use App\Models\BorrowedBook;
use Livewire\Component;
use Livewire\WithPagination;

class BorrowedBooks extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'tailwind';

//    protected string $paginationTheme = 'custom';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $borrowedBooks = BorrowedBook::with(['book.category', 'member.profile'])
            ->where('member_id', auth()->id()) // atau sesuaikan dengan kebutuhan
            ->where('code', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.borrowed-books', [
            'borrowedBooks' => $borrowedBooks,
        ]);
    }
}
