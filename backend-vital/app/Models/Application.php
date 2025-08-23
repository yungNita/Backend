<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'fullname',
        'position_name',
        'ph_num',
        'email',
        'cv_file',
        'remark',
        'date_applied',
        'department',
        'company',
        'other_file',
        'status',
        // 'job_id',
    ];

    // public function job()
    // {
    //     return $this->belongsTo(Job::class, 'job_id');
    // }
}
