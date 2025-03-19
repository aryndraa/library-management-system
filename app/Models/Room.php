<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
