<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    //
    protected $table = 'tbl_prescriptions';
    protected $fillable = ['patient_id', 'dentist_id', 'medicine_id', 'treatment_detail_id', 'quantity'];
}
