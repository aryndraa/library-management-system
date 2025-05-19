<?php

namespace App\Http\Controllers\Member\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use function Symfony\Component\VarDumper\Dumper\esc;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $sort     = $request->input('sort');
        $category = $request->input('categories');

        $books = Book::query()
            ->withCount(['borrowings', 'likes'])
            ->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->when($category, function ($query) use ($category) {
                return $query->whereHas('category', function ($query) use ($category) {
                    return $query->whereIn('name', (array) $category);
                });
            })
            ->when($sort, function ($query) use ($sort) {
                if($sort == 'newest') {
                    return $query->orderBy('created_at', 'desc');
                } else if($sort == 'oldest') {
                    return $query->orderBy('created_at', 'asc');
                } else if($sort == 'hots') {
                    return $query->orderBy('borrowings_count', 'desc');
                } else if($sort == 'popular') {
                    return $query->orderBy('likes_count', 'desc');
                }

                return null;
            })
            ->where('library_id', session('library_id_session'))
            ->paginate(20);

        return view('user.book.index', compact('books'));
    }
}
