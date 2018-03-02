<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditTrails extends Model
{
    //
    protected $fillable=[
        'user_id','date_made','activity'
    ];
}
