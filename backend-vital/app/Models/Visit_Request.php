<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
        'visit_updated_by',
        'number_of_visitors',
        'status',
    ];
    public static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->visit_updated_by = Auth::id();
        });
    }
}
