<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    protected $table = 'tbl_patients';
    protected $fillable = ['name', 'address', 'phone', 'date_of_birth', 'gender', 'avatar', 'district_id', 'is_parent'];

    public function parent()
    {
        return $this->belongsTo('App\Model\Patient', 'parent_id');
    }
    public function children()
    {
        return $this->hasMany('App\Model\Patient', 'parent_id');
    }

    public function belongsToUser(){
        return $this->belongsTo('App\Model\User', 'phone', 'phone');
    }
    public function hasFeedback()
    {
        return $this->hasMany('App\Model\Feedback', 'patient_id', 'id');
    }

    public function belongsToDistrict(){
        return $this->belongsTo('App\Model\District', 'district_id', 'id');
    }

    public function hasAnamnesisPatient()
    {
        return $this->hasMany('App\Model\AnamnesisPatient', 'patient_id', 'id');
    }

    public function hasPayment(){
        return $this->hasMany('App\Model\Payment', 'patient_id', 'id');
    }
    public function hasTreatmentHistory(){
        return $this->hasMany('App\Model\TreatmentHistory', 'patient_id', 'id');
    }
}
