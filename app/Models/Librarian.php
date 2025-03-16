<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Librarian extends Model
{
    protected $fillable = [
        'library_id',
        'name',
        'email',
        'password'
    ];

    public function library(): HasOne {
        return $this->hasOne(Library::class);
    }
}
