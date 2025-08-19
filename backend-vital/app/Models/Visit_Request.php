<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit_Request extends Model
{
    //
    protected $table = 'visit_requests';
    protected $primaryKey = 'visit_id';
    protected $fillable = [
        'visit_firstname',
        'visit_lastname',
        'visit_email',
        'visit_phNum',
        'visit_institute',
        'visit_purpose',
        'visit_amount',
        'status',
    ];
}
