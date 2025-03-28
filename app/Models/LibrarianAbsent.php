<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibrarianAbsent extends Model
{
    use HasFactory;

    protected $fillable = [
        'status'
    ];

    public function librarian(): BelongsTo
    {
        return $this->belongsTo(Librarian::class);
    }
}
