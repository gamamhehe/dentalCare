<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $table = 'tbl_appointments';
    protected $fillable = ['id', 'date_booking', 'note', 'time_booking', 'dentist_id', 'phone'];
    public function belongsToUser(){
        return $this->belongsTo('App\Model\User', 'phone', 'phone');
    }
    public function belongsToDentist(){
        return $this->belongsTo('App\Model\Staff', 'dentist_id', 'id');
    }
}
