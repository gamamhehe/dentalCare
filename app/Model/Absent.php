<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    //
    protected $table = 'tbl_absents';
    protected $fillable = ['staff_approve_id', 'request_absent_id', 'message_from_staff', 'created_time', 'is_approved'];
    public function belongsToRequestAbsent(){
        return $this->belongsTo('App\Model\RequestAbsent','request_absent_id', 'id');
    }
    public function belongsToStaff(){
        return $this->belongsTo('App\Model\Staff','staff_approve_id', 'id');
    }
}
