<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function userGroup(){
        return $this->belongsTo('\App\UserGroup','id_user_group');
    }

    public static function getUsersMaster(){
        return DB::table('users')->where('id_user_group', 1)->get();
    }
}
