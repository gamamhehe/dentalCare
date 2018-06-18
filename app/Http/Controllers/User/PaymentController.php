<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BusinessFunction\PaymentBusinessFunction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    //
    use PaymentBusinessFunction;
    public function getPaymentOfUser(Request $request){
        $currentUser = $request->session()->get('currentUser', null);
        return $this->getPaymentByPhone($currentUser->phone);
    }

    public function getListPayment(){
        $paymentList = $this->getAllPayment();
        return view('admin.news.list', ['paymentList' => $paymentList]);
    }

    public function createPaymentForPatient(){

    }

}
