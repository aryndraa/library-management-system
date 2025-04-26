<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Filament\Models\Contracts\HasName;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Librarian extends Authenticatable Implements HasMedia, HasName
{
    use HasApiTokens, HasFactory, InteractsWithMedia, Notifiable ;

    protected $fillable = [
        'library_id',
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

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
