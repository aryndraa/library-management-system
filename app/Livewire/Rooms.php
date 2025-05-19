<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\RoomCategory;
use Livewire\Attributes\Url;
use Livewire\Component;

class Rooms extends Component
{
    #[Url(except: '')]
    public string
        $search = '',
        $sort   = '';

    #[Url(except: [])]
    public array $categories = [];

    #[Url(except: 1)]
    public int $page = 1;

    public array $sortItems = [];
    public array $categoryList = [];

    public function mount()
    {
        $this->sortItems = [
            'newest',
            'oldest',
        ];

        $this->categoryList = RoomCategory::all()->pluck('name')->toArray();
    }

    public function render()
    {
        $rooms = Room::query()
            ->when($this->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->categories, function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->whereIn('name', (array) $this->categories);
                });
            })
            ->when($this->sortItems, function ($query) {
                return match ($this->sort) {
                    'newest'  => $query->orderBy('created_at', 'desc'),
                    'oldest'  => $query->orderBy('created_at', 'asc'),
                    default   => $query,
                };
            })
            ->where('library_id', session('library_id_session'))
            ->paginate(20);

        return view('livewire.rooms', [
            'rooms' => $rooms,
        ]);
    }
}
