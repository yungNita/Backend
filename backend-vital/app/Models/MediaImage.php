<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'media_id',
        'path',
        'is_cover',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
