<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 11-Aug-18
 * Time: 21:36
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TreatmentHistorySymptom extends Model
{
    protected $table = 'tbl_treatment_history_symptoms';
    protected $primaryKey = ['treatment_history_id', 'role_id'];
    public $incrementing = false;
    protected $fillable = ['treatment_history_id', 'symptom_id'];

    public function belongsToTreatmentHistory()
    {
        return $this->belongsTo('App\Model\TreatmentHistory', 'treatment_history_id', 'id');
    }

    public function belongsToSymptom()
    {
        return $this->belongsTo('App\Model\Symptom', 'symptom_id', 'id');
    }


    protected function setKeysForSaveQuery(Builder $query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}