<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table = 'tbl_cities';
    protected $fillable = ['id', 'name'];
    public function hasDistrict(){
        return $this->hasMany('App\Model\District', 'city_id', 'id');
    }
}
