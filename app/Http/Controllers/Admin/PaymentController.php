<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\PaymentBusinessFunction;
use App\Model\Payment;
use App\Model\PaymentDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    //
    use PaymentBusinessFunction;

    public function getOfUser(Request $request)
    {
        $currentUser = $request->session()->get('currentUser', null);

        $listPayment = $this->getPaymentByPhone($currentUser->phone);
        return view("WebUser.Payment", ['listPayment' => $listPayment]);
    }

    public function getList()
    {
        $paymentList = $this->getListPayment();
        return view('admin.news.list', ['paymentList' => $paymentList]);
    }

    public function searchCurrent(Request $request)
    {
        return $this->checkPaymentIsDone($request->phone);
    }

    public function createDetail(Request $request)
    {
        $paymentDetail = new PaymentDetail();
        $sessionUser = $request->session()->get('currentAdmin', null);
        if ($sessionUser) {
            $idStaff = $sessionUser->belongToStaff()->first()->id;;
        } else {
            return route('admin.login');
        }
        $paymentDetail->staff_id = $idStaff;
        $paymentDetail->payment_id = $request->payment_id;
        $paymentDetail->received_money = $request->received_money;
        $paymentDetail->create_date = Carbon::now();
        $this->createPaymentDetail($paymentDetail);
        $this->updatePayment(-($request->received_money), $request->payment_id);
        return true;
    }
}
