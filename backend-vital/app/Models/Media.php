<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'url',
        'article_detail', 
        'scheduled_at',
        'published_at',
        'created_by',
        'created_by_username',
        'modified_by',
        'modified_by_username',
    ];

    protected $dates = [
        'published_at',
        'scheduled_at',
        'deleted_at',
    ];

    // owner of the media
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // admin who created
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // admin who modified
    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    // one-to-one relations
    public function event()
    {
        return $this->hasOne(UpcomingEvent::class, 'media_id');
    }

    // one-to-many
    public function images()
    {
        return $this->hasMany(MediaImage::class, 'media_id');
    }

    public function coverImage()
    {
        return $this->hasOne(MediaImage::class)->where('is_cover', true);
    }
}
