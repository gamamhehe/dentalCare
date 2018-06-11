<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TreatmentStep extends Model
{
    //
    protected $table = 'tbl_treatment_steps';
    protected $fillable = ['step_id', 'treatment_id', 'description'];
    public function belongsToTreatment(){
        return $this->belongsTo('App\Model\Treatment', 'treatment_id', 'id');
    }
    public function belongsToStep(){
        return $this->belongsTo('App\Model\Step', 'step_id', 'id');
    }
}
