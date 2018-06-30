<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
    protected $table = 'tbl_feedbacks';
    protected $fillable = ['id', 'content', 'patient_id', 'treatment_detail_id', 'date_feedback', 'num_of_stars'];


    public function belongsToPatient(){
        return $this->belongsTo('App\Model\User', 'patient_id', 'id');
    }

    public function belongsToTreatmentDetail(){
        return $this->belongsTo('App\Model\TreatmentDetail', 'treatment_detail_id', 'id');
    }
}
