<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 11-Aug-18
 * Time: 21:36
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class TreatmentHistorySymptom extends Model
{
    protected $table = 'tbl_treatment_history_symptoms';
    protected $fillable = ['treatment_history_id', 'symptom_id'];

    public function belongsToTreatmentHistory()
    {
        return $this->belongsTo('App\Model\TreatmentHistory', 'treatment_history_id', 'id');
    }

    public function belongsToSymptom()
    {
        return $this->belongsTo('App\Model\Symptom', 'symptom_id', 'id');
    }

}