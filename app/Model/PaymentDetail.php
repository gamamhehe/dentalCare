<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    //
    protected $table = 'tbl_payment_details';
    protected $fillable = ['id', 'payment_id', 'receptionist_id', 'date_create', 'received_money'];
    public function beLongsToStaff(){
        return $this->belongsTo('App\Model\Staff','receptionist_id', 'id');
    }
    public function beLongsToPayment(){
        return $this->belongsTo('App\Model\Payment','payment_id', 'id');
    }
}
