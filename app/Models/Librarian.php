<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class Librarian extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'library_id',
        'email',
        'password'
    ];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
}
