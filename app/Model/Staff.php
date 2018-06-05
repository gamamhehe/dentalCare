<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    //
    protected $table = 'tbl_staffs';
    protected $fillable = ['id', 'name','special', 'date_of_birth', 'phone', 'gender', 'avatar'];
    public function getUser(){
        return $this->belongsTo('App\Model\User','phone', 'phone');
    }
}
