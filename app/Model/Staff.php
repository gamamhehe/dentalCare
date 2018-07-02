<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    //
    protected $table = 'tbl_staffs';
    protected $fillable = ['name','degree','address', 'district_id', 'date_of_birth', 'phone', 'gender', 'avatar'];
    public function belongsToUser(){
        return $this->belongsTo('App\Model\User','phone', 'phone');
    }
    public function hasAbsent(){
        return $this->hasMany('App\Model\RequestAbsent', 'staff_id', 'id');
    }
    public function approveAbsent(){
        return $this->hasMany('App\Model\Absent', 'staff_approve_id', 'id');
    }
    public function hasEvent(){
        return $this->hasMany('App\Model\Event', 'staff_id', 'id');
    }
    public function hasPaymentDetail(){
        return $this->hasMany('App\Model\PaymentDetail', 'receptionist_id', 'id');
    }
    public function hasNews(){
        return $this->hasMany('App\Model\News', 'staff_id', 'id');
    }
    public function hasTreatmentDetail(){
        return $this->hasMany('App\Model\TreatmentDetail', 'dentist_id', 'id');
    }
    public function hasAppointment(){
        return $this->hasMany('App\Model\Appointment', 'dentist_id', 'id');
    }
}
