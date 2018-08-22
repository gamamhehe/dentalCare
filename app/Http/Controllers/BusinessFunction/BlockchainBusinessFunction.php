<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Helpers\AppConst;
use App\Model\Absent;
use App\Model\Blockchain;
use App\Model\Role;
use App\RequestAbsent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Model\NodeInfo;
use App\Model\Payment;
use App\Model\PaymentDetail;
use App\Model\PaymentUpdateDetail;
use App\Model\Treatment;
use DB;

trait BlockchainBusinessFunction
{

    public function saveNewAll($ledgerObject)
    {
        if ($ledgerObject != null) {
            Blockchain::query()->delete();
            $count = 0;
            $number = 1;
//            tbl_blockchains
            \DB::statement('ALTER TABLE tbl_blockchains AUTO_INCREMENT = 1;');
            foreach ($ledgerObject as $element) {
                $block = new Blockchain();
                $tmp = (Object)$element;
                $block->data_encrypt = $tmp->data_encrypt;
                $block->previous_hash = $tmp->previous_hash;
                $block->hash = $tmp->hash;
                $result = $block->save();
                if ($result) {
                    $count++;
                } else {
                    Log::info("BlockchainBusinessFunction_saveNewAll_CannotAddBlock: " . $number);
                }
                $number++;
            }
            return json_encode($count);
        }
        return '0';
    }


    public function getDataBlockChain()
    {
        $blockchains = Blockchain::all();
        return $blockchains;
    }

    public function getNodeInfo()
    {
        $nodeInfo = NodeInfo::all();
        return $nodeInfo;
    }

    public function deleteDataPayment()
    {
        PaymentUpdateDetail::query()->delete();
        PaymentDetail::query()->delete();
//        Payment::query() -> delete();
        \DB::statement('ALTER TABLE tbl_payment_details AUTO_INCREMENT = 1;');
        \DB::statement('ALTER TABLE tbl_payment_update_details AUTO_INCREMENT = 1;');
    }

    public function setDataCreatePayment($element)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::where('id', $element[0])->first();
            if ($payment) {
                $payment->paid = 0;
                $payment->total_price = $element[2];
                $payment->phone = $element[3];
                $payment->status = $element[4];
                $payment->save();
            }else{
                Payment::create([
                    'id' => $element[0],
                    'paid' => 0,
                    'total_price' => $element[2],
                    'phone' => $element[3],
                    'status' => $element[4],
                ]);
                $payment->save();
            }
            var_dump(1);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return false;
        }
    }

    public function setDataPaymentDetail($element)
    {
        DB::beginTransaction();
        try {
            PaymentDetail::create([
                'payment_id' => $element[1],
                'staff_id' => $element[2],
                'created_date' => $element[3],
                'received_money' => $element[4],
            ]);
            $payment = Payment::where('id', $element[1])->first();
            $payment->paid = $payment->paid + $element[4];
            if ($payment->total_price == $payment->paid) {
                $payment->status =  AppConst::PAYMENT_STATUS_DONE;
            }
            $payment->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function setDataUpdatePayment($element)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::find($element[0]);
            $nameTreatment = Treatment::where('id', $element[3])->first()->name;
            $total_price = (int)$element[1] + (int)$element[2];
            $updateInformation = 'Tổng tiền chi trả thay đổi từ ' . $element[1] . ' VND sang '
                . $total_price . ' VND để thanh toán cho liệu trình ' . $nameTreatment;
            PaymentUpdateDetail::create([
                'payment_id' => $element[0],
                'update_information' => $updateInformation,
            ]);
            $payment->total_price = $total_price;
            $payment->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}