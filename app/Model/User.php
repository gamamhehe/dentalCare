<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table = 'tbl_users';
    protected $fillable = ['phone', 'password', 'isDeleted'];
    public function hasRole(){
        return $this->hasMany('App\Model\UserHasRole', 'phone', 'phone');
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
