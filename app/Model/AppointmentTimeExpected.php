<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AppointmentTimeExpected extends Model
{
    //
    protected $table = 'tbl_appointment_time_expected';
    protected $fillable = ['appointment_id', 'treatment_id', 'description'];

}
