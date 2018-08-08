<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $table = 'tbl_events';
    protected $fillable = ['id', 'name', 'start_date', 'end_date', 'discount', 'staff_id', 'created_date', 'treatment_id'];
    public function belongsToStaff(){
        return $this->belongsTo('App\Model\Staff', 'staff_id', 'id');
    }
    public function belongsToTreatment(){
        return $this->belongsTo('App\Model\Treatment', 'treatment_id', 'id');
    }
}
