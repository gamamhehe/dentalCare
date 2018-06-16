<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'tbl_payments';
    protected $fillable = ['id', 'prepaid', 'note_payable','total_price', 'phone', 'is_done'];
    public function beLongsToUser(){
        return $this->belongsTo('App\Model\User','phone', 'id');
    }
    public function beLongsToTreatmentHistory(){
        return $this->hasMany('App\Model\TreatmentHistory','payment_id', 'id');
    }
    public function hasPaymentDetail(){
        return $this->hasMany('App\Model\PaymentDetail', 'payment_id', 'id');
    }
}
