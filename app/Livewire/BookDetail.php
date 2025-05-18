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

    public bool $openComment = false;

    public $bookComments;

    public ?int $editingCommentId = null;
    public string $editingMessage = '';

    public ?int $activeCommentMenu = null;

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

        flash()->success('Comment added successfully');
    }

    public function toggleCommentMenu($commentId)
    {
        $this->activeCommentMenu = $this->activeCommentMenu === $commentId ? null : $commentId;
    }

    public function startEditing($commentId)
    {

        $this->activeCommentMenu = false;
        $comment = $this->book->bookComments()->findOrFail($commentId);


        $this->editingCommentId = $commentId;
        $this->editingMessage = $comment->message;
    }

    public function updateComment()
    {
        $comment = $this->book->bookComments()->findOrFail($this->editingCommentId);

        $comment->update([
            'message' => $this->editingMessage,
        ]);

        $this->editingCommentId = null;
        $this->editingMessage = '';

        flash()->success('Comment updated successfully');
    }

    public function deleteComment($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $this->book->bookComments()->where('id', $id)->delete();

        flash()->success('Comment deleted successfully');
    }

    public function render()
    {
        $this->bookComments = $this->book->bookComments()->with(['member.profile', 'member.profile.photoProfile'])->get();

        return view('livewire.book-detail');
    }
}
