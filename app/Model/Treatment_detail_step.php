<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Treatment_detail_step extends Model
{
    //
    protected $table = 'tbl_treatment_detail_steps';
    protected $fillable = ['treatment_detail_id', 'treatment_step_id', 'description'];
}
