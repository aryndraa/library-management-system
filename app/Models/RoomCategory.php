<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomCategory extends Model
{
    protected $fillable = [
        'name',
        'code'
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
