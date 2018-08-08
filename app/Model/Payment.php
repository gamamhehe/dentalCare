<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'tbl_payments';
    protected $fillable = ['id', 'paid','total_price', 'phone', 'is_done'];
    public function beLongsToUser(){
        return $this->belongsTo('App\Model\User','phone', 'phone');
    }
    public function hasManyTreatmentHistory(){
        return $this->hasMany('App\Model\TreatmentHistory','payment_id', 'id');
    }
    public function hasPaymentDetail(){
        return $this->hasMany('App\Model\PaymentDetail', 'payment_id', 'id');
    }
    public function hasPaymentUpdateDetail(){
        return $this->hasMany('App\Model\PaymentUpdateDetail', 'payment_id', 'id');
    }
}
