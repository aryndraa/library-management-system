<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class Librarian extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'library_id',
        'email',
        'password'
    ];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function profile(): HasOne
    {
        return $this->hasone(LibrarianProfile::class);
    }

    public function borrowedPenalties(): HasMany
    {
        return $this->hasMany(BorrowedPenalty::class);
    }

    public function shift(): HasMany
    {
        return $this->hasMany(LibrarianShift::class);
    }

}
