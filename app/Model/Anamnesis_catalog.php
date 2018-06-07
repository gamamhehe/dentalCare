<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Anamnesis_catalog extends Model
{
    //
    protected $table = 'tbl_anamnesis_catalogs';
    protected $fillable = ['id', 'name', 'description'];
    public function hasPatient(){
        return $this->hasMany('App\Model\Anamnesis_patient', 'anamnesis_id', 'id');
    }
}
