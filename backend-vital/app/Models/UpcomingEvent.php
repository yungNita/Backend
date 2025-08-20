<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UpcomingEvent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'detail',
        'start_date',
        'end_date',
        'location,'
        'num_paticipate',
        'organizer',
        'contact',
        'expired_at',
        'timeline',
    ]

    public function media()
    {
        return $this->belongTo(Media::class);
    }
}
