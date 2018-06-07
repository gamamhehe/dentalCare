<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    //
    protected $guard = 'admins';
    protected $table = 'tbl_users';
    protected $fillable = ['phone', 'password', 'isActive', 'isDelete'];
    protected $hidden = [
        'password','remember_token'
    ];
    public function hasRole(){
        return $this->hasOne('App\Model\User_has_role', 'phone', 'phone');
    }
    public function belongToStaff(){
        return $this->hasOne('App\Model\Staff', 'phone', 'phone');
    }

    public function hasPatient(){
        return $this->hasMany('App\Model\Patient', 'phone', 'phone');
    }

    public function hasAppointment(){
        return $this->hasMany('App\Model\Appointment', 'phone', 'phone');
    }
}
