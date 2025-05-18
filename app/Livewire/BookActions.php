<?php

namespace App\Livewire;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use const http\Client\Curl\AUTH_ANY;

class BookActions extends Component
{
    public Book $book;

    public bool
        $isLiked,
        $isBorrowed;

    public function mount(Book $book)
    {
        $this->book       = $book;
        $this->isLiked    = Auth::user()->bookLikes->contains($book);
        $this->isBorrowed = Auth::user()->borrowedBooks->contains($book);
    }

    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        if($this->isLiked) {
            $this->book->likes()->detach(Auth::id());
            $this->isLiked = false;
        } else {
            $this->book->likes()->attach(Auth::id());
            $this->isLiked = true;
        }

        $this->book->refresh();
    }

    public function render()
    {
        return view('livewire.book-actions');
    }
}
