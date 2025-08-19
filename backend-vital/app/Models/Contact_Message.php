<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact_Message extends Model
{
    //
    protected $table = 'contact__messages';
    protected $primaryKey = 'message_id';
    protected $fillable = [
        'message_firstname',
        'message_lastname',
        'message_email',
        'message_phNum',
        'message_detail',
    ];
}
