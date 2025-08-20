<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
 use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category',
        'title',
        'thumbnail_img',
        'source',
        'status',
        'scheduled_at'
        'published_at'
        'created_by',
        'created_by_username',
        'modified_by',
        'modified_by_username',
    ]

    public function user()
    {
        return $this->belongsTo(User::class);
    }   

    public function event() 
    {
        return $this->hasOne(UpcomingEvent::class);
    }

    public function images() 
    {
        return $this->hasMany(MediaImage::class);
    }

    public function links()
    {
        return $this->hasMany(MediaLink::class);
    }

    public function article() 
    {
        return $this->hasOne(MediaArticle::class);
    }
}
