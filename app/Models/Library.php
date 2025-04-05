<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Library extends Model
{
    use HasFactory;

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

    public function librarians(): HasMany
    {
        return $this->hasMany(Librarian::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function roomBookings(): HasManyThrough
    {
        return $this->hasManyThrough(RoomBooking::class, Room::class);
    }

    public function memberVisits(): HasMany
    {
        return $this->hasMany(MemberVisit::class);
    }
}
