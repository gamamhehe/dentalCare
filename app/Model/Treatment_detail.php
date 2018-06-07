<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Treatment_detail extends Model
{
    //
    protected $table = 'tbl_treatment_details';
    protected $fillable = ['id', 'treatment_history_id', 'treatment_id', 'note', 'dentist_id', 'create_date', 'payment_id'];
}
