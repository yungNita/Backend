<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post_Job extends Model
{
    //
    protected $table = 'post__jobs';
    protected $primaryKey = 'job_id';
    protected $dates = ['created_at', 'job_updated_at', 'job_deleted_at', 'published_at', 'scheduled_at', 'closed_at'];
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
        'job_updated_by',
        'status',
        'scheduled_at',
        'closed_at',
    ];
}
