<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowedBook extends Model
{
    protected $fillable = [
        'borrowed_date',
        'due_date',
        'returned_date',
        'code'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function library() : BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
}
