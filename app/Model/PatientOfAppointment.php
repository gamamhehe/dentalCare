<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PatientOfAppointment extends Model
{
    //
    protected $table = 'tbl_patient_of_appointment';
    protected $primaryKey = ['appointment_id', 'patient_id'];
    public $incrementing = false;
    protected $fillable = ['appointment_id', 'patient_id'];
    public function belongsToAppointment(){
        return $this->belongsTo('App\Model\Appointment','appointment_id', 'id');
    }
    public function belongsToPatient(){
        return $this->belongsTo('App\Model\Patient','patient_id', 'id');
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
