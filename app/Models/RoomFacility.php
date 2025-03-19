<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomFacility extends Model
{
    protected $fillable = [
        'facility',
        'description',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
