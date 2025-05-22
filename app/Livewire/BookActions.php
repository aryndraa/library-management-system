<?php

namespace App\Livewire;

use App\Models\Admin;
use App\Models\Book;
use App\Models\Librarian;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
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

        flash()->success('Pending borrowed successfully');

        $book = $this->book;
        $book->stock -= 1;
        $book->save();

        /** @var Librarian $user */
        $librarians = Librarian::query()->get();

        foreach ($librarians as $librarian) {
            Notification::make()
                ->title('Book borrowed pending')
                ->icon('heroicon-o-book-open')
                ->body("Book **{$book->title}** from library **{$book->library?->name}** has been pending to borrowed.")
                ->duration(10)
                ->sendToDatabase($librarian);

            event(new DatabaseNotificationsSent($librarian));
        }

        $this->isBorrowed = true;

        $this->book->refresh();
    }

    public function render()
    {
        return view('livewire.book-actions');
    }
}
