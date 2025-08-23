<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class MediaLink extends Model
{
    // use SoftDeletes;

    protected $fillable = ['media_id', 'url'];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
