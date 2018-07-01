<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TreatmentDetailStep extends Model
{
    //
    protected $table = 'tbl_treatment_detail_steps';
    protected $fillable = ['treatment_detail_id', 'step_id', 'description'];
    public function belongsToTreatmentDetail(){
        return $this->belongsTo('App\Model\TreatmentDetail', 'treatment_detail_id', 'id');
    }
    public function belongsToStep(){
        return $this->belongsTo('App\Model\Step', 'step_id', 'id');
    }
}
