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
        dd("Null");
        return null;
    }

    public function updatePayment($price, $idPayment)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::find($idPayment);
            $payment->total_price = $payment->total_price + $price;
            if ($payment->total_price == 0) {
                $payment->is_done = true;
            }
            $payment->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function updatePaymentPrepaid($price, $idPayment)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::find($idPayment);
            $payment->prepaid = $payment->prepaid + $price;
            if ($payment->total_price == $payment->prepaid) {
                $payment->is_done = true;
            }
            $payment->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
    public function updatePaymentNotePayable($amount, $idPayment)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::find($idPayment);
            $payment->note_payable = $payment->note_payable - $amount;
            if ($payment->total_price == $payment->note_payable) {
                $payment->is_done = true;

            }
            $Staff = $payment->beLongsToUser()->first()->belongToStaff()->first();
            $paymentDetail = new PaymentDetail();
            $paymentDetail->payment_id =$idPayment;
            $paymentDetail->received_money = $amount;
            $paymentDetail->date_create = Carbon::now();
            $paymentDetail->staff_id = $Staff->id;

            $payment->save();
            $paymentDetail->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw new Exception($e);
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
            dd($e);
            return false;
        }
    }
}