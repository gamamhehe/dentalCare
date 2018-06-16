<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $table = 'tbl_appointments';
    protected $fillable = ['id', 'start_time', 'note', 'estimated_time', 'numerical_order', 'phone'];
    public function belongsToUser(){
        return $this->belongsTo('App\Model\User', 'phone', 'phone');
    }
}
