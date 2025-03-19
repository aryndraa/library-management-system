<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibrarianAbsent extends Model
{
    protected $fillable = [
        'status'
    ];

    public function librarian(): BelongsTo
    {
        return $this->belongsTo(Librarian::class);
    }
}
