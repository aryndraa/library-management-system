<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryBook extends Model
{
    protected $fillable = [
        "stocks",
    ];

    public function book() : BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function library() : BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
}
