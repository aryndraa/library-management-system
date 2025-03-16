<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'isbn',
        'author',
        'publisher',
        'pages',
        'publication_date'
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
