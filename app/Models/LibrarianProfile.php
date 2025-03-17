<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LibrarianProfile extends Model
{
    protected $fillable = [
      'librarian_id',
      'first_name',
      'last_name',
      'phone',
      'gender',
      'address',
      'province',
      'city',
      'birth_date',
    ];

    public function librarian(): BelongsTo {
        return $this->belongsTo(Librarian::class);
    }
}
