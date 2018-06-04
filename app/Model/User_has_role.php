<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User_has_role extends Model
{
    //
    protected $table = 'tblUser_has_role';
    protected $fillable = ['phone', 'role_id', 'role_start_time', 'role_end_time'];
    public function User(){
        return $this->belongsTo('App\Model\User', 'phone', 'phone');
    }
    public function Role(){
        return $this->belongsTo('App\Model\Role', 'role_id', 'id');
    }
}
