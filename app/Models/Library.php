<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Library extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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

    public function picture(): MorphOne
    {
        return $this->morphOne(File::class, 'related');
    }
}
