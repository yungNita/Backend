<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpcomingEvent extends Model
{

    protected $fillable = [
        'title',
        'detail',
        'start_date',
        'end_date',
        'location',
        'num_participate',
        'organizer',
        'contact',
        'media_id',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}

