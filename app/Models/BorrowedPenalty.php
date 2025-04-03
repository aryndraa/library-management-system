<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowedPenalty extends Model
{
    protected $fillable = [
        'penalty',
        'message',
        'charge',
        'due'
    ];

    public function borrowedBook(): BelongsTo
    {
        return $this->belongsTo(BorrowedBook::class, 'book_id');
    }

}
