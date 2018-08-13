<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //P
    protected $primaryKey = "id";
    protected $table = 'tbl_appointments';
    protected $fillable = ['id', 'name','start_time', 'note', 'estimated_time', 'numerical_order', 'phone', 'staff_id', 'is_delete', 'is_coming'];
    public function belongsToUser(){
        return $this->belongsTo('App\Model\User', 'phone', 'phone');
    }
    public function belongsToStaff(){
        return $this->belongsTo('App\Model\Staff', 'staff_id', 'id');
    }
    public function hasPatientOfAppointment(){
        return $this->hasOne('App\Model\PatientOfAppointment', 'appointment_id', 'id');
    }
}
