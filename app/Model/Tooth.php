<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tooth extends Model
{
    //
    protected $table = 'tbl_tooths';
    protected $fillable = ['tooth_number', 'tooth_name'];
    public function hasTreatmentHistory(){
        return $this->hasMany('App\Model\TreatmentHistory', 'tooth_number', 'tooth_number');
    }
}
