<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Anamnesis_patient extends Model
{
    //
    protected $table = 'tbl_anamnesis_patients';
    protected $fillable = ['patient_id', 'anamnesis_id', 'description'];
    public function belongsToAnamnesis(){
        return $this->belongsTo('App\Model\Anamnesis_catalog', 'anamnesis_id', 'id');
    }
    public function belongsToPatient(){
        return $this->belongsTo('App\Model\Patient', 'patient_id', 'id');
    }
}
