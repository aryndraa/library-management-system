<?php

namespace App\Http\Controllers\Member\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use function Symfony\Component\VarDumper\Dumper\esc;

class   BookController extends Controller
{
    public function index(Request $request)
    {
        return view('user.book.index');
    }

    public function show(Book $book)
    {
        $book->newQuery()
            ->with('category');

        return view('user.book.show', compact(['book']));
    }
}
