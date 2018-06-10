<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TreatmentStep extends Model
{
    //
    protected $table = 'tbl_treatment_steps';
    protected $fillable = ['id', 'name', 'treatment_id', 'description'];
}
