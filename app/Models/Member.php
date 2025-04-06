<?php

namespace App\Models;

use Doctrine\DBAL\SQL\Parser\Visitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
    ];

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
