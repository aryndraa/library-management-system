<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'library_id',
        'category_id',
        'title',
        'isbn',
        'author',
        'publisher',
        'pages',
        'stock',
        'publication_date',
        'synopsis'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    Public function borrowings(): HasMany
    {
        return $this->hasMany(BorrowedBook::class);
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'member_book_likes', 'book_id', 'member_id');
    }

    public function bookComents (): HasMany
    {
        return $this->hasMany(BookComment::class);
    }
}

