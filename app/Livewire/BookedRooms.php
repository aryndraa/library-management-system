<?php

namespace App\Livewire;

use App\Models\BorrowedBook;
use App\Models\Library;
use App\Models\RoomBooking;
use Livewire\Component;
use Livewire\WithPagination;

class BookedRooms extends Component
{

    use WithPagination;

    public $search = '';

    public $selectedLibrary;

    public $libraries = [];

    public function mount()
    {
        $this->selectedLibrary = session('library_id_session');

        $this->libraries = Library::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingLibraryId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $rooms = RoomBooking::with(['room', 'room.category', 'room.library'])
            ->when($this->search, function ($query) {
                $query->whereHas('room', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('code', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedLibrary !== session('library_id_session'), function ($q) {
                return $q->whereHas('room', function ($q) {
                    $q->where('library_id', $this->selectedLibrary);
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.booked-rooms', [
            'rooms' => $rooms
        ]);
    }
}
