<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 11-Aug-18
 * Time: 21:34
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    protected $table = 'tbl_symptoms';
    protected $fillable = ['id', 'name', 'description'];

    public function hasTreatmentHistory()
    {
        return $this->hasMany('App\Model\TreatmentHistorySymptom', 'treatment_history_id', 'id');
    }

}