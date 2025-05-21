<?php

namespace App\Livewire;

use App\Models\BorrowedBook;
use App\Models\Library;
use Illuminate\Database\Query\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class BorrowedBooks extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'tailwind';

    public $selectedLibrary = '';
    public $libraries = [];

//    protected string $paginationTheme = 'custom';

    public function mount()
    {
        $this->selectedLibrary = session('library_id_session');
        $this->libraries = Library::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedLibrary()
    {
        $this->resetPage();
    }


    public function render()
    {
        $borrowedBooks = BorrowedBook::with(['book.category', 'member.profile'])
            ->where('member_id', auth()->id())
            ->when($this->selectedLibrary !== session('library_id_session'), function ($q) {
                $q ->whereHas('book', function ($q) {
                    $q->where('library_id', $this->selectedLibrary);
                });
            })
            ->when($this->search, fn ($q) => $q->where('code', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate(10);

        return view('livewire.borrowed-books', [
            'borrowedBooks' => $borrowedBooks,
        ]);
    }
}
