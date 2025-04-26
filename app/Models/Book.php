<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Book extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'library_id',
        'category_id',
        'title',
        'isbn',
        'author',
        'publisher',
        'pages',
        'stock',
        'publication_date',
        'synopsis'
    ];

    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = Str::title($title);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    Public function borrowings(): HasMany
    {
        return $this->hasMany(BorrowedBook::class);
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'member_book_likes', 'book_id', 'member_id');
    }

    public function bookComments (): HasMany
    {
        return $this->hasMany(BookComment::class);
    }

    public function cover (): MorphOne
    {
        return $this->morphOne(File::class , 'related');
    }
}

