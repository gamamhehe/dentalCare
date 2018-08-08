<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AnamnesisPatient extends Model
{
    //
    protected $table = 'tbl_anamnesis_patients';
    protected $primaryKey = ['patient_id', 'anamnesis_id'];
    public $incrementing = false;
    protected $fillable = ['patient_id', 'anamnesis_id', 'description'];
    public function belongsToAnamnesisCatalog(){
        return $this->belongsTo('App\Model\AnamnesisCatalog', 'anamnesis_id', 'id');
    }
    public function belongsToPatient(){
        return $this->belongsTo('App\Model\Patient', 'patient_id', 'id');
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
