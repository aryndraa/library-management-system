<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberVisit extends Model
{
    use HasFactory;

    protected $table = 'member_visits';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
}
