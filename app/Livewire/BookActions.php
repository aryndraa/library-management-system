<?php

namespace App\Livewire;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        $this->isBorrowed = Auth::user()->borrowedBooks()
                                ->where('book_id', $book->id)
                                ->whereNot('status', 'returned')
                                ->exists();


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

    public function borrowBook()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $this->book->borrowings()->create([
            'member_id'     => Auth::id(),
            'library_id'    => session('library_id_session'),
            'borrowed_date' => now(),
            'due_date'      => now()->addDays(5),
            'status'        => 'pending',
            'code'          => 'BRW-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
        ]);

        flash()->success('Book borrowed successfully');

        $this->isBorrowed = true;

        $this->book->refresh();
    }

    public function render()
    {
        return view('livewire.book-actions');
    }
}
