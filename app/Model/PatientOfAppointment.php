<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PatientOfAppointment extends Model
{
    //
    protected $table = 'tbl_patient_of_appointment';
    protected $fillable = ['appointment_id', 'patient_id'];
    public function belongsToAppointment(){
        return $this->belongsTo('App\Model\Appointment','appointment_id', 'id');
    }
    public function belongsToPatient(){
        return $this->belongsTo('App\Model\Patient','patient_id', 'id');
    }
}
