<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\DocBlock\Tags\Implements_;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Librarian extends Authenticatable Implements HasMedia, HasName
{
    use HasApiTokens, HasFactory, InteractsWithMedia, Notifiable ;

    protected $fillable = [
        'library_id',
        'email',
        'password'
    ];

    public function getFilamentName(): string
    {
        return $this->profile->first_name . ' ' . $this->profile->last_name ?? 'Librarian';
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($librarian) {
            $librarian->absents()->delete();
            $librarian->profile()->delete();
            $librarian->shifts()->delete();
        });
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(LibrarianProfile::class);
    }

    public function shifts(): HasMany
    {
        return $this->hasMany(LibrarianShift::class);
    }

    public function absents(): HasMany
    {
        return $this->hasMany(LibrarianAbsent::class);
    }
}
