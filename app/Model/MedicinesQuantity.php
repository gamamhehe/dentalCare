<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MedicinesQuantity extends Model
{
    //
    protected $table = 'tbl_medicines_quantity';
    protected $primaryKey = ['medicine_id', 'treatment_detail_id'];
    public $incrementing = false;
    protected $fillable = ['patient_id', 'dentist_id', 'medicine_id', 'treatment_detail_id', 'quantity'];
    public function belongsToTreatmentDetail(){
        return $this->belongsTo('App\Model\TreatmentDetail','treatment_detail_id', 'id');
    }
    public function belongsToMedicine(){
        return $this->belongsTo('App\Model\Medicine', 'medicine_id', 'id');
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
