<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Project_Proposal extends Model
{
    //
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'project_proposals';
    protected $primaryKey = 'project_id';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'project_firstname',
        'project_lastname',
        'project_email',
        'project_phNum',
        'project_projectName',
        'project_detail',
        'project_updated_by',
        'project_file',
        'status',
    ];
    public static function boot(){
        parent::boot();

        static::updating(function ($model) {
            $model->project_updated_by = Auth::id();
        });
    }
}
