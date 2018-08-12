<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TreatmentHistory extends Model
{
    //
    protected $table = 'tbl_treatment_histories';
    protected $fillable = ['id', 'treatment_id','patient_id', 'description', 'created_date', 'finish_date', 'tooth_number', 'price', 'payment_id', 'total_price'];

    public function belongsToTreatment(){
        return $this->belongsTo('App\Model\Treatment', 'treatment_id', 'id');
    }
    public function hasTreatmentDetail(){
        return $this->hasMany('App\Model\TreatmentDetail', 'treatment_history_id', 'id');
    }
    public function hasTreatmentSymptom(){
        return $this->hasMany('App\Model\TreatmentHistorySymptom', 'treatment_history_id', 'id');
    }
    public function belongsToTooth(){
        return $this->belongsTo('App\Model\Tooth', 'tooth_number', 'tooth_number');
    }
    public function belongsToPatient(){
        return $this->belongsTo('App\Model\Patient', 'patient_id', 'id');
    }
    public function belongsToPayment(){
        return $this->belongsTo('App\Model\Payment', 'payment_id', 'id');
    }
}
