<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post_Job extends Model
{
    //
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'post__jobs';
    protected $primaryKey = 'job_id';
    protected $dates = ['created_at', 'closed_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'closed_at' => 'datetime',
    ];
    protected $fillable = [
        'position',
        'salary',
        'location',
        'deadline',
        'working_shift',
        'job_detail',
        'employment_type',
        'department',
        'company',
        'published_by',
        'published_at',
        'scheduled_at',
        'job_updated_by',
        'status',
        'closed_at',
        'is_available'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->published_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            $model->job_updated_by = Auth::id();
        });
    }
}
