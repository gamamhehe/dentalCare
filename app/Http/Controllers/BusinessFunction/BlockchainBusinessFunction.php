<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


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

    public function deleteDataPayment(){
        Payment::query() -> delete();
        PaymentDetail::query() -> delete();
        PaymentUpdateDetail::query() -> delete();
    }

    public function setDataCreatePayment($element)
    {
        DB::beginTransaction();
        try {
            Payment::create([
                'paid' => $element[1],
                'total_price' => $element[2],
                'phone' => $element[3],
                'status' => $element[4],
                'created_at' => $element[5],
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
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
            $nameTreatment = Treatment::where('id', $element[2])->first()->name;
            $updateInformation = 'Tổng tiền chi trả thay đổi từ ' . $payment->total_price . ' VND sang '
                . $element[1] . ' VND để thanh toán cho liệu trình ' . $nameTreatment;
            PaymentUpdateDetail::create([
                'payment_id' => $element[0],
                'update_information' => $updateInformation,
            ]);
            $payment->total_price = (int)$element[1];
            $payment->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}