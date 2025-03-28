<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibrarianShift extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        "clock_in",
        "clock_out",
    ];

    public function librarian(): BelongsTo
    {
        return $this->belongsTo(Librarian::class);
    }
}
