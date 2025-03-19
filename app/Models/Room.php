<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'name',
        'type',
        'price'
    ];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function facilities(): HasMany
    {
        return $this->hasMany(RoomFacility::class);
    }
}
