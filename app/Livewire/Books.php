<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Books extends Component
{
    use WithPagination;

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

    public bool $expanded = false;


    public function mount()
    {
        $this->sortItems = [
            'newest',
            'oldest',
            'hots',
            'popular'
        ];

        $this->categoryList = Category::all()->pluck('name')->toArray();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function updatingCategories()
    {
        $this->resetPage();
    }

    public function getVisibleCategoriesProperty()
    {
        return array_slice($this->categoryList, 0, $this->expanded ? count($this->categoryList) : 8);
    }


    public function render()
    {
        $books = Book::query()
            ->withCount(['borrowings', 'likes'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->categories, function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->whereIn('name', (array) $this->categories);
                });
            })
            ->when($this->sort, function ($query) {
                return match ($this->sort) {
                    'newest'  => $query->orderBy('created_at', 'desc'),
                    'oldest'  => $query->orderBy('created_at', 'asc'),
                    'hots'    => $query->orderBy('borrowings_count', 'desc'),
                    'popular' => $query->orderBy('likes_count', 'desc'),
                    default   => $query,
                };
            })
            ->where('library_id', session('library_id_session'))
            ->latest()
            ->paginate(12);

        return view('livewire.books', [
            'books' => $books,
        ]);
    }
}
