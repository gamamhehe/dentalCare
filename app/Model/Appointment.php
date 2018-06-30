<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $table = 'tbl_appointments';
    protected $fillable = ['start_time', 'note', 'estimated_time', 'numerical_order', 'phone', 'dentist_id'];
    public function belongsToUser(){
        return $this->belongsTo('App\Model\User', 'phone', 'phone');
    }
    public function belongsToStaff(){
        return $this->belongsTo('App\Model\Staff', 'dentist_id', 'id');
    }
}
