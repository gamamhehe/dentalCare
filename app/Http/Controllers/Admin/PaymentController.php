<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\PaymentBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Model\Payment;
use App\Model\PaymentDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    //
    use PaymentBusinessFunction;
    use UserBusinessFunction;
    public function create(Request $request){
        $checkExist = $this->checkExistUser($request->phone);
        if ($checkExist) {
            $idPayment = $request->payment_id;
            $received_money = $request->received_money;
            $paymentDetail = new PaymentDetail();
            $paymentDetail->payment_id = $idPayment;
            $paymentDetail->created_date = Carbon::now();
            $paymentDetail->received_money = $received_money;
            $paymentDetail->staff_id = $request->session()->get('currentAdmin', null)->belongToStaff()->first()->id;
            $this->createPaymentDetail($paymentDetail);
            $result = $this->updatePaymentPaid($received_money, $idPayment);
            if($result){
                return true;
            }else{
                return false;
            }
        }else{
            return redirect()->back()->with('error', '')->withInput($request->only('phone'));
        }

    }
    public function getOfUser(Request $request)
    {
        $currentUser = $request->session()->get('currentUser', null);

        $listPayment = $this->getPaymentByPhone($currentUser->phone);
        return view("WebUser.Payment", ['listPayment' => $listPayment]);
    }

    public function getList()
    {
        $paymentList = $this->getListPayment();
        return view('admin.payment.list', ['paymentList' => $paymentList]);
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
            $idStaff = $sessionUser->belongToStaff()->first()->id;
        } else {
            return route('admin.login');
        }
        $paymentDetail->staff_id = $idStaff;
        $paymentDetail->payment_id = $request->payment_id;
        $paymentDetail->received_money = $request->received_money;
        $paymentDetail->created_date = Carbon::now();
        $this->createPaymentDetail($paymentDetail);
        $this->updatePaymentPrepaid($request->received_money, $request->payment_id);
        return true;
    }

    public function search($searchValue)
    {
        $output = '';
        $data = $this->searchPayment($searchValue);

        $total_row = $data->count();


        if ($total_row > 0) {
            foreach ($data as $row) {
                if ($row->status) {
                    $output .= '
         <tr class="even gradeC" align="left">
            <td style="text-align: center">{{$row->phone}}</td>
            <td style="text-align: center">{{$row->total_price}}</td>
            <td style="text-align: center">{!! $row->paid !!}</td>
            <td style="text-align: center">Đã Hoàn Thành</td>
            <td align="center" style="width: 20%">
            <form action="/admin/get-payment-detail">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="idPayment" value="'. $row->id .'">
                <button type="submit" class="btn btn-default btn-success">Xem Chi Tiết Chi Trả</button>
            </form>

            </td>
         </tr>
        ';
                }else{
                    $output .= '
         <tr class="even gradeC" align="left">
            <td style="text-align: center">'.$row->phone.'</td>
            <td style="text-align: center">'.$row->total_price.'</td>
            <td style="text-align: center">'. $row->paid .'</td>
            <td style="text-align: center">Chưa Hoàn Thành</td>
            <td align="center" style="width: 20%">
            <form action="/admin/get-payment-detail">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="idPayment" value="'. $row->id .'">
                <button type="submit" class="btn btn-default btn-success">Xem Chi Tiết Chi Trả</button>
            </form>
            </td>
         </tr>
        ';
                }
            }
        }
        if ($total_row == 0) {
            $output = '
       <tr>
        <td align="center" colspan="5">Không Có Chi Trả Nào</td>
       </tr>
       ';
        }


        $data = array(
            'table_data' => $output,
            'total_data' => $total_row
        );
        echo json_encode($data);
    }

    public function getDetail(Request $request){
        $listDetail = $this->getDetailListPaymentById($request->idPayment);
        $payment = $this->getPaymentById($request->idPayment);
        $payment->updateList = $payment->hasPaymentUpdateDetail()->get();
        $listTreatmentHistory = $payment->hasManyTreatmentHistory()->get();
        $listTreatment = [];
        foreach ($listTreatmentHistory as $treatmentHistory){
            $listTreatment[] = $treatmentHistory->belongsToTreatment()->first()->name;
        }
        $payment->listTreatment = $listTreatment;
        return view('admin.payment.detail', ['listDetail' => $listDetail, 'payment' => $payment]);
    }

}
