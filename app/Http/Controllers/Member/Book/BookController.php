<?php

namespace App\Http\Controllers\Member\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $sort     = $request->input('sort');
        $category = $request->input('category');

        $books = Book::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->when($category, function ($query) use ($category) {
                return $query->whereHas('category', function ($query) use ($category) {
                    return $query->where('id', $category);
                });
            })
            ->when($sort, function ($query) use ($sort) {
                return $query->orderBy($sort, 'desc');
            })
            ->where('library_id', session('library_id_session'))
            ->paginate(20);

        return view('user.book.index', compact('books'));
    }
}
