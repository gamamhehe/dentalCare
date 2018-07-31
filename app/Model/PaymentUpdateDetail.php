<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentUpdateDetail extends Model
{
    //
    protected $table = 'tbl_payment_update_details';
    protected $fillable = ['payment_id', 'update_information'];
    public function beLongsToPayment(){
        return $this->belongsTo('App\Model\Payment','payment_id', 'id');
    }
}
