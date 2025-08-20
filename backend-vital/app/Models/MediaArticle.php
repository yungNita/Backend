<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaArticle extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'media_id', 'detail']

    public function media()
    {
        return $this->belongTo(Media::class);
    }

    public function image()
    {
        return $this->hasMany(MediaImage::class);
    }
}
