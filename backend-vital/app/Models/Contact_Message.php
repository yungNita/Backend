<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact_Message extends Model
{
    //
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'contact__messages';
    protected $primaryKey = 'message_id';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'message_firstname',
        'message_lastname',
        'message_email',
        'message_phNum',
        'message_detail',
    ];
}
