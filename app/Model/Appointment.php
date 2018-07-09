<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $table = 'tbl_appointments';
    protected $fillable = ['name','start_time', 'note', 'estimated_time', 'numerical_order', 'phone', 'staff_id', 'patient_id', 'is_delete', 'is_coming'];
    public function belongsToUser(){
        return $this->belongsTo('App\Model\User', 'phone', 'phone');
    }
    public function belongsToStaff(){
        return $this->belongsTo('App\Model\Staff', 'staff_id', 'id');
    }
    public function belongsToPatient(){
        return $this->belongsTo('App\Model\Patient', 'patient_id', 'id');
    }
}
