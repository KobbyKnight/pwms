<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
'gender',
'dob',
'username',
'email',
'official_phone',
'password',
    //if user is inactive it will be 1
'is_locked',
    // if user is logged in it will be 1
'is_login',
'user_ip',

'department_id',
'school_id',
    //who created the user
'created_by',
'password_attempt_count',
'password_attempt_date',
'must_change_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


public function department(){
    return $this->belongsTo('App\Department','department_id','id');
}
}
