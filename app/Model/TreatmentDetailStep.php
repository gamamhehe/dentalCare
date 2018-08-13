<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TreatmentDetailStep extends Model
{
    //
    protected $table = 'tbl_treatment_detail_steps';
    protected $primaryKey = ['treatment_detail_id', 'step_id'];
    protected $fillable = ['treatment_detail_id', 'step_id', 'description'];
    public function belongsToTreatmentDetail(){
        return $this->belongsTo('App\Model\TreatmentDetail', 'treatment_detail_id', 'id');
    }
    public function belongsToStep(){
        return $this->belongsTo('App\Model\Step', 'step_id', 'id');
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
