<?php

namespace App\Livewire;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BookDetail extends Component
{
    public Book $book;

    public $randomBooks;

    public bool $openComment = true;

    public $bookComments;

    #[Validate('required')]
    public string $message = '';

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

    public function sendComment()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $this->book->bookComments()->create([
            'member_id' => Auth::id(),
            'message'   => $this->message,
        ]);

        $this->message = '';
    }

    public function render()
    {
        $this->bookComments = $this->book->bookComments()->with(['member.profile', 'member.profile.photoProfile'])->get();

        return view('livewire.book-detail');
    }
}
