<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookOverview extends Component
{
    public string $filter = 'new';

    public function setFilter(string $value)
    {
        $this->filter = $value;
    }

    public function getBooksProperty()
    {
        return match ($this->filter) {
            'popular' => Book::with('category')
                ->withCount('borrowings')
                ->orderByDesc('borrowings_count')
                ->take(8)
                ->get(),

            'recommended' => Book::with('category')
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->take(8)
                ->get(),

            default => Book::with('category')
                ->latest()
                ->take(8)
                ->get(), // new
        };
    }

    public function render()
    {
        return view('livewire.book-overview');
    }
}
