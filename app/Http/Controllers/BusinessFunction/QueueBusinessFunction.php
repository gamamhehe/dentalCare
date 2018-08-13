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

    public function callTheURL($url)
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->get($url);
        $data = $request->getBody()->getContents();
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
            if (is_integer((int)$id) && $id == 0) {
                return '2';
            }
        }
        return $result->status;
    }

}