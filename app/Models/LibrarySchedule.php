<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibrarySchedule extends Model
{
    protected $fillable = [
        'library_id',
        'day',
        'opening_time',
        'closing_time'
    ];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
}
