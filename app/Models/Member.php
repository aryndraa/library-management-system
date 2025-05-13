<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Member extends Authenticatable Implements HasMedia, HasName
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $fillable = [
        'email',
        'password',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getFilamentName(): string
    {
        return $this->profile->first_name . ' ' . $this->profile->last_name ?? 'Librarian';
    }

    public function profile(): HasOne
    {
        return $this->hasOne(MemberProfile::class);
    }

    public function borrowedBooks(): HasMany
    {
        return $this->hasMany(BorrowedBook::class);
    }

    public function bookLikes(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'member_book_likes', 'member_id', 'book_id');
    }

    public function bookComments(): HasMany
    {
        return $this->hasMany(BookComment::class);
    }

    public function bookReplyComments(): HasMany
    {
        return $this->hasMany(BookReplyComment::class);
    }

    public function roomBookings(): HasMany
    {
        return $this->hasMany(RoomBooking::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(MemberVisit::class);
    }

}
