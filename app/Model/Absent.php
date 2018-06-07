<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    //
    protected $table = 'tbl_absents';
    protected $fillable = ['staff_id', 'staff_approve_id', 'date_absent'];
}
