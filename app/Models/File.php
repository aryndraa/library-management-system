<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\UploadedFile;

class File extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
    ];

    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }

        return secure_asset(null);
    }

    public static function uploadFile(UploadedFile $file, Model $model, $relation, $directory)
    {
        $filePath = $file->store($directory, 'public');
        $fileName = $file->getClientOriginalName();
        $fileType = $file->getMimeType();

        return $model->$relation()->create([
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $fileType,
        ]);
    }

    public function related(): MorphTo {
        return $this->morphTo();
    }
}
