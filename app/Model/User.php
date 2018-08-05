<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'tbl_users';
    protected $primaryKey = "phone";
    protected $casts = ['phone' => 'string'];
    protected $fillable = ['phone', 'password', 'is_deleted'];

    public function findForPassport($phone)
    {
        return $this->where('phone', $phone)->first();
    }

    public function hasToken()
    {
        return $this->hasMany('\App\Model\OauthAccessToken', 'user_id', 'phone');
    }

    public function hasFirebaseToken(){
        return $this->hasMany('App\Model\FirebaseToken','phone', 'phone');
    }

    public function hasUserHasRole()
    {
        return $this->hasMany('App\Model\UserHasRole', 'phone', 'phone');
    }

    public function belongToStaff()
    {
        return $this->hasOne('App\Model\Staff', 'phone', 'phone');
    }

    public function hasPatient()
    {
        return $this->hasMany('App\Model\Patient', 'phone', 'phone');
    }

    public function hasAppointment()
    {
        return $this->hasMany('App\Model\Appointment', 'phone', 'phone');
    }
}
