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
        DB::beginTransaction();
        try {
            $id = Queue::create(['data_encrypt' => $dataEncrypt, 'status' => $status, 'ip' => $ip])->id;
            DB::commit();
            return json_encode($id);
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function addToAllNodeInNetWork($dataEncrypt)
    {
        $host = gethostname();
        $currentIp = gethostbyname($host);
        $listNode = $this->getListNode();
        $id = 0;
        foreach ($listNode as $node) {
            $ip = $node->ip;
            $url = $ip . '/addToQueue?data_encrypt=' . $dataEncrypt . '&ip=' . $currentIp; //the ip of current server
            $id = $this->callTheURL($url);
        }
        return $id; // all id is the same
    }

    public function updateRecordById($id)
    {
        DB::beginTransaction();
        try {
            $record = Queue::find($id);
            $record->status = 2;
            $record->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::info('Error in QueueBussinessFunction: ' . $e->getMessage());
            return false;
        }
        return false;
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

    public function updateAllQueue($id)
    {
        $count = 0;
        $listNode = $this->getListNode();
        foreach ($listNode as $node) {
            $ip = $node->ip;
            $url = $ip . '/updateQueue?id=' . $id;
            $result = $this->callTheURL($url);
            if ($result == 'success') {
                $count++;
            } else if ($result == 'fail') {
                Log::info('QueueBusinessFunction_updateAllQueue_ResultNotSuccessWithIP: ' . $ip);
            } else {
                Log::info('QueueBusinessFunction_updateAllQueue_Error');
            }
        }
        return $count;
    }

    public function checkStatus($id)
    {
        $result = Queue::find($id);
        if ($result == null) {
            $obj = Queue::all()->first();
            if ($obj != null) {
                $firstId = $obj->id;
                if ($firstId == $id + 1) {
                    return '2';
                } else {
                    Log::info("QueueBusinessFunction_checkStatus_Error");
                    return null;
                }
            } else {
                return '2';
            }
        }
        return $result->status;
    }


}