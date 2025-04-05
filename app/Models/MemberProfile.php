<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'birthday',
        'gender',
        'address',
        'province',
        'city',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
