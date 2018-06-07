<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //
    protected $table = 'tbl_districts';
    protected $fillable = ['id', 'name', 'city_id'];
    public function hasPatient(){
        return $this->hasMany('App\Model\Patient', 'district_id', 'id');
    }
    public function belongsToCity(){
        return $this->belongsTo('App\Model\City', 'city_id', 'id');
    }
}
