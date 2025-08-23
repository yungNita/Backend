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
    ];

    protected $dates = ['deleted_at']
    
    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function getFullPathAttribute()
    {
        return asset('storage/' . $this->path);
    }

}
