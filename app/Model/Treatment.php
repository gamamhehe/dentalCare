<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    //
    protected $table = 'tbl_treatments';
    protected $fillable = ['id', 'name', 'description', 'treatment_category_id', 'min_price', 'max_price'];
    public function hasEvent(){
        return $this->hasMany('App\Model\Event', 'treatment_id', 'id');
    }
    public function belongsToTreatmentCategory(){
        return $this->belongsTo('App\Model\TreatmentCategory', 'treatment_category_id', 'id');
    }

    public function hasTreatmentHistory(){
        return $this->hasMany('App\Model\TreatmentHistory', 'treatment_id', 'id');
    }

    public function hasTreatmentStep(){
        return $this->hasMany('App\Model\TreatmentStep', 'treatment_id', 'id');
    }
}
