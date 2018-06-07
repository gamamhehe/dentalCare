<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'tbl_payments';
    protected $fillable = ['id', 'treatment_history_id', 'patient_id', 'treatment_id', 'date_pay', 'prepaid', 'note_payable', 'receptionist_id'];
}
