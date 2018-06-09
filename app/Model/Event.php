<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $table = 'tbl_events';
    protected $fillable = ['id', 'name', 'start_date', 'end_date', 'discount', 'staff_id', 'create_date', 'treatment_id'];
}
