<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    //
    protected $guard = 'admins';
    protected $table = 'tblUsers';
    protected $fillable = ['phone', 'password', 'isActive', 'isDelete'];
    protected $hidden = [
        'password','remember_token'
    ];
    public function has_role(){
        return $this->hasOne('App\Model\User_has_role', 'phone', 'phone');
    }
}
