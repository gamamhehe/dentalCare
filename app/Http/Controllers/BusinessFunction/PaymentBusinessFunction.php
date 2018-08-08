<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 17-Jun-18
 * Time: 23:01
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Payment;
use App\Model\PaymentDetail;
use App\Model\PaymentUpdateDetail;
use App\Model\Treatment;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

trait PaymentBusinessFunction
{
    public function getPaymentByPhone($phone)
    {
        $payments = Payment::where('phone', $phone)->get();
        foreach ($payments as $item) {
            $listPaymentDetail = $item->hasPaymentDetail()->get();
            foreach ($listPaymentDetail as $paymentDetail) {
                $paymentDetail->staff = $paymentDetail->beLongsToStaff()->first();
            }
            $treatmentNames = [];
            $listTreatmentHistories = $item->hasManyTreatmentHistory()->get();
            foreach ($listTreatmentHistories as $treatmentHistory) {
                if ($treatmentHistory->belongsToTreatment() != null) {
                    $treatmentNames[] = $treatmentHistory->belongsToTreatment()->first()->name;
                }
            }
            $item->payment_details = $listPaymentDetail;
            $item->treatment_names = $treatmentNames;
        }
        return $payments;
    }

    public function getListPayment()
    {
        $payments = Payment::all();
        return $payments;
    }

    public function getPaymentById($id)
    {
        $payment = Payment::where('id', $id)->first();
        return $payment;
    }

    public function createPayment($total_price, $phone)
    {
        DB::beginTransaction();
        try {
            $id = Payment::create([
                'total_price' => $total_price,
                'phone' => $phone,
            ])->id;
            DB::commit();
            return $id;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function checkPaymentIsDone($phone)
    {
        $listPayment = Payment::where('phone', $phone)->get();
        foreach ($listPayment as $payment) {
            if ($payment->is_done == false) {
                return $payment;
            }
        }
        return null;
    }

    public function updatePayment($price, $idPayment, $idTreatment)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::find($idPayment);
            $nameTreatment = Treatment::where('id', $idTreatment)->first()->name;
            $updatePrice = (int)$payment->total_price + (int)$price;
            $updateInformation = 'Tổng tiền của chi trả thay đổi từ ' . $payment->total_price . ' VND sang '
                . $updatePrice . ' VND để thanh toán cho liệu trình ' . $nameTreatment;
            PaymentUpdateDetail::create([
                'payment_id' => $idPayment,
                'update_information' => $updateInformation,
            ]);
            $payment->total_price = $payment->total_price + $price;
            $payment->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    public function updatePaymentModel($payment, $paymentDetail)
    {
        DB::beginTransaction();
        try {
            $payment->save();
            $paymentDetail->save();
            DB::commit();
            return true;
        } catch (Exception $exception) {
            DB::rollback();
            throw  new \Exception($exception->getMessage());
        }

    }

    public function updatePaymentPaid($price, $idPayment)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::find($idPayment);
            $payment->paid = $payment->paid + $price;

            if ($payment->total_price == $payment->paid) {
                $payment->is_done = true;
            }
            $payment->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw new Exception($e->getMessage());
            return false;
        }
    }

    public function createPaymentDetail($paymentDetail)
    {
        DB::beginTransaction();
        try {
            $paymentDetail->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function searchPayment($phone)
    {
        return Payment::where('phone', $phone)->get();
    }

    public function getDetailListPaymentById($idPayment)
    {
        $result = PaymentDetail::where('payment_id', $idPayment)->get();
        foreach ($result as $detail) {
            $detail->staff = $detail->beLongsToStaff()->first()->name;
        }
        return $result;
    }

    public function getReport($monthInNumber, $yearInNumber)
    {
        $data = DB::select(DB::raw("SELECT sum(tmh.total_price) as total_price, staff.id as staff_id ,staff.name as staff_name FROM
(
    select  min(td_created_date) as td_created_date , treatment_history_id FROM
    (
SELECT th.id as treatment_history_id, td.created_date as td_created_date FROM tbl_treatment_histories as th
JOIN tbl_treatment_details  as td ON th.id = td.treatment_history_id
        WHERE MONTH(th.created_date) = :month AND YEAR(th.created_date) = :year
    ) as suq
    GROUP BY suq.treatment_history_id
) as submin
   JOIN tbl_treatment_details as tmd ON tmd.created_date = submin.td_created_date
   JOIN tbl_staffs as staff ON staff.id= tmd.staff_id
   JOIN tbl_treatment_histories as tmh ON tmh.id= submin.treatment_history_id
   GROUP BY staff.id,staff.name"),
            array(
                'month' => $monthInNumber,
                'year' => $yearInNumber
            ));
        return $data;
    }
}