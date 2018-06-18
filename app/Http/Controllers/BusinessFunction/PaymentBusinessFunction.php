<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 17-Jun-18
 * Time: 23:01
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Payment;

trait PaymentBusinessFunction
{
    public function getPaymentByPhone($phone){
        $payments = Payment::where('phone', $phone)->get();
        foreach($payments as $item){
            $item->payment_details = $item->hasPaymentDetail();
        }
        return $payments;
    }

    public  function  getAllPayment(){
        $payments = Payment::all();
        return $payments;
    }
}