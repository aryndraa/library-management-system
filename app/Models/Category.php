<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = Str::title($name);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
