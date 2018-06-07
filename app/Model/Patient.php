<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    protected $table = 'tbl_patients';
    protected $fillable = ['id', 'name', 'address', 'phone', 'date_of_birth', 'gender', 'avatar', 'district_id', 'parent_id'];

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
        return $this->belongsTo('App\Model\District', 'id', 'district_id');
    }

    public function hasAnamnesis()
    {
        return $this->hasMany('App\Model\Anamnesis_patient', 'patient_id', 'id');
    }
}
