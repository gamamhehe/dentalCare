<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MedicinesQuantity extends Model
{
    //
    protected $table = 'tbl_medicines_quantity';
    protected $fillable = ['patient_id', 'dentist_id', 'medicine_id', 'treatment_detail_id', 'quantity'];
    public function belongsToTreatmentDetail(){
        return $this->belongsTo('App\Model\TreatmentDetail','treatment_detail_id', 'id');
    }
    public function hasMedicine(){
        return $this->belongsTo('App\Model\Medicine', 'medicine_id', 'id');
    }
}
