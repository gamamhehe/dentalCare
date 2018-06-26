<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 17-Jun-18
 * Time: 23:09
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\PaymentBusinessFunction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    use PaymentBusinessFunction;
        public function getByPhone(Request $request){
            try {
                $phone = $request->input('phone');
                $payments = $this->getPaymentByPhone($phone);
                return response()->json($payments, 200);
            }catch (\Exception $ex){
                $error = new \stdClass();
                $error->error="Có lỗi xảy ra, không thể lấy dữ liệu";
                $error->exception = $ex->getMessage();
                return response()->json($error, 400);
            }
        }
}