<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AnamnesisCatalog extends Model
{
    //
    protected $table = 'tbl_anamnesis_catalogs';
    protected $fillable = ['id', 'name', 'description'];
    public function hasAnamnesisPatient(){
        return $this->hasMany('App\Model\AnamnesisPatient', 'anamnesis_id', 'id');
    }

}
