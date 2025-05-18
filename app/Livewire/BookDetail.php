<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookDetail extends Component
{
    public Book $book;

    public $randomBooks;

    public bool $openComment = true;

    public $bookComments;

    public function mount(Book $book)
    {
        $this->book = $book;

        $this->randomBooks = Book::query()->inRandomOrder()
            ->take(6)
            ->get();
    }

    public function toggleComment($condition)
    {
        $this->openComment = $condition;
    }

    public function render()
    {
        $this->bookComments = $this->book->bookComments()->with(['member.profile', 'member.profile.photoProfile'])->get();

        return view('livewire.book-detail');
    }
}
