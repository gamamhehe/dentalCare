<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Absent;
use App\Model\Queue;
use App\Model\Role;
use App\RequestAbsent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait QueueBusinessFunction
{
    use NodeInfoBusinessFunction;

    public function createNewRecordInQueue($dataEncrypt, $status, $ip)
    {
        $checkExistIp = $this->isExist($ip);
        if ($checkExistIp == true) {
            DB::beginTransaction();
            try {
                $id = Queue::create(['data_encrypt' => $dataEncrypt, 'status' => $status, 'ip' => $ip,])->id;
                DB::commit();
                return json_encode($id);
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        }
    }

    public function addToAllNodeInNetWork($dataEncrypt)
    {
        $currentIp = \request()->ip();
        $listNode = $this->getListNode();
        $id = 0;
        foreach ($listNode as $node) {
            $ip = $node->ip;
            $url = $ip . '/addToQueue?data_encrypt=' . $dataEncrypt . '&ip=' . $currentIp; //the ip of current server
            $id = $this->callTheURL($url);
        }
        return $id; // all id is the same
    }

    public function updateRecordByDataEncrypt($dataEncrypt)
    {
        DB::beginTransaction();
        try {
            $record = Queue::where('data_encrypt', '=', $dataEncrypt);
            $record->status = 2;
            $record->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::info('Error in QueueBussinessFunction: ' . $e->getMessage());
            return false;
        }
    }

    private function callTheURL($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function updateAllQueue($dataEncrypt)
    {
        $result = '';
        $listNode = $this->getListNode();
        foreach ($listNode as $node) {
            $ip = $node->ip;
            $url = $ip . '/updateQueue?data_encrypt=' . $dataEncrypt;
            $result = $this->callTheURL($url);
        }
    }

    public function checkStatus($dataEncrypt)
    {
        return Queue::where('data_encrypt','=', $dataEncrypt)->first()->status;
    }

    public function isYourTurn($currentIp){
        $id = Queue::where('status','=', 2)->last()->id;
        $ip = Queue::find($id + 1)->ip;
        if($ip == $currentIp)
            return true;
        return false;
    }



}