<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BorrowedBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'member_id',
        'library_id',
        'borrowed_date',
        'due_date',
        'status',
        'code',
        'returned_date',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

}
