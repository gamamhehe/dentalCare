<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'tbl_payments';
    protected $fillable = ['id', 'treatment_history_id', 'patient_id', 'treatment_id', 'date_pay', 'prepaid', 'note_payable', 'receptionist_id'];
    public function beLongsToPatient(){
        return $this->belongsTo('App\Model\Patient','patient_id', 'id');
    }
    public function beLongsToStaff(){
        return $this->belongsTo('App\Model\Staff','receptionist_id', 'id');
    }
    public function beLongsToTreatmentDetail(){
        return $this->belongsTo('App\Model\TreatmentDetail','treatment_detail_id', 'id');
    }
    public function hasPaymentDetail(){
        return $this->hasMany('App\Model\PaymentDetail', 'payment_id', 'id');
    }
}
