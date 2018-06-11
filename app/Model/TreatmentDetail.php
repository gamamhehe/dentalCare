<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TreatmentDetail extends Model
{
    //
    protected $table = 'tbl_treatment_details';
    protected $fillable = ['id', 'treatment_history_id', 'treatment_id', 'note', 'dentist_id', 'create_date', 'payment_id'];
    public function hasTreatmentImage(){
        return $this->hasMany('App\Model\TreatmentImage', 'treatment_detail_id', 'id');
    }
    public function hasPayment(){
        return $this->hasMany('App\Model\Payment', 'treatment_detail_id', 'id');
    }
    public function hasFeedback(){
        return $this->hasOne('App\Model\Feedback','treatment_detail_id', 'id');
    }
    public function hasTreatmentDetailStep(){
        return $this->hasMany('App\Model\TreatmentDetailStep', 'treatment_detail_id', 'id');
    }
    public function belongsToStaff(){
        return $this->belongsTo('App\Model\Staff', 'dentist_id', 'id');
    }
    public function hasMedicinesQuantity(){
        return $this->hasMany('App\Model\MedicinesQuantity', 'treatment_detail_id', 'id');
    }
    public function belongsToTreatmentHistory(){
        return $this->belongsTo('App\Model\TreatmentHistory', 'treatment_history_id', 'id');
    }
}
