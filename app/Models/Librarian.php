<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class Librarian extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'library_id',
        'email',
        'password'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($librarian) {
            $librarian->absents()->delete();
            $librarian->profile()->delete();
            $librarian->shifts()->delete();
        });
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(LibrarianProfile::class);
    }

    public function shifts(): HasMany
    {
        return $this->hasMany(LibrarianShift::class);
    }

    public function absents(): HasMany
    {
        return $this->hasMany(LibrarianAbsent::class);
    }
}
