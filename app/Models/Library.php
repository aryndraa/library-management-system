<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Library extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'opening_time',
        'closing_time',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function memberVisits(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'member_visits', 'library_id', 'user_id');
    }
}
