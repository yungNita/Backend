<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project_Proposal extends Model
{
    //
    protected $table = 'project_proposals';
    protected $primaryKey = 'project_id';
    protected $fillable = [
        'project_firstname',
        'project_lastname',
        'project_email',
        'project_phNum',
        'project_projectName',
        'project_detail',
        'status',
    ];
}
