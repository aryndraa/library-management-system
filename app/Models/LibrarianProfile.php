<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class LibrarianProfile extends Model
{
    use HasFactory;

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

    public function librarian(): BelongsTo
    {
        return $this->belongsTo(Librarian::class);
    }

    public function photoProfile(): MorphOne
    {
        return $this->morphOne(File::class, 'related');
    }
}
