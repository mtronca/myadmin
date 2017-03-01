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
        'name', 'email', 'password', 'id_user_group'
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

    public static function criar($input){

        DB::table('users')->insert([
            [
                'email' => $input['email'],
                'name' => $input['name'],
                'password' => bcrypt($input['password']),
                'id_user_group' => $input['id_user_group'],
					 'created_at' => date('Y-m-d H:i:s')
            ]
        ]);

        $id_user = DB::getPdo()->lastInsertId();


        return $id_user;
    }

    public static function editar($input, $id){

        $updateArray = [
            'email' => $input['email'],
            'name' => $input['name'],
            'thumbnail_principal' => $input['thumbnail_principal'],
            'id_user_group' => $input['id_user_group'],
				'updated_at' => date('Y-m-d H:i:s')
        ];

        if($input['password'] != ''){
            $updateArray['password'] = bcrypt($input['password']);
        }

        return DB::table('users')->where('id', $id)
        ->update($updateArray);
    }
}
