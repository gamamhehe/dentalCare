<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\PaymentBusinessFunction;
use App\Model\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    //
    use PaymentBusinessFunction;
    public function getOfUser(Request $request){
        $currentUser = $request->session()->get('currentUser', null);
        $listPayment = $this->getPaymentByPhone($currentUser->phone);
        dd($currentUser);
        return view("WebUser.Payment",['listPayment '=>1]);
    }

    public function getListPayment(){
        $paymentList = $this->getAllPayment();
        return view('admin.news.list', ['paymentList' => $paymentList]);
    }
}
