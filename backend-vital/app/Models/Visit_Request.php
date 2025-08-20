<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit_Request extends Model
{
    //
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'visit_requests';
    protected $primaryKey = 'visit_id';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'visit_firstname',
        'visit_lastname',
        'visit_email',
        'visit_phNum',
        'visit_institute',
        'visit_purpose',
        'number_of_visitors',
        'status',
    ];
}
