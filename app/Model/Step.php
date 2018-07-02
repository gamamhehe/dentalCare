<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $table = 'tbl_steps';
    protected $fillable = ['id', 'name', 'description'];
    public function hasTreatmentDetailStep(){
        return $this->hasMany('App\Model\TreatmentDetailStep', 'step_id', 'id');
    }
    public function hasTreatmentStep(){
        return $this->hasMany('App\Model\TreatmentStep', 'step_id', 'id');
    }
}
