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

    public function createNewRecordInQueue($data_encrypt, $status, $ip)
    {
        $checkExistIp = $this->isExist($ip);
        if ($checkExistIp == true) {
            DB::beginTransaction();
            try {
                $id = Queue::create(['data_encrypt' => $data_encrypt, 'status' => $status, 'ip' => $ip,])->id;
                DB::commit();
                return json_encode($id);
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        }
        return '';
    }

    public function addToAllNodeInNetWork($data_encrypt)
    {
        $currentIp = $_SERVER['REMOTE_ADDR']; //dd($_SERVER) for more details
        $listNode = $this->getListNode();
        $id = 0;
        foreach ($listNode as $node) {
            $ip = $node->ip;
            $url = $ip . '/addToQueue?data_encrypt=' . $data_encrypt . '&ip=' . $currentIp; //the ip of current server
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
            Log::info('Error in QueueBussinessFunction: '.$e->getMessage());
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

    public function updateAllQueue($id)
    {
        $result = '';
        $listNode = $this->getListNode();
        foreach ($listNode as $node) {
            $ip = $node->ip;
            $url = $ip . '/updateQueue?id=' . $id;
            $result = $this->callTheURL($url);
        }
    }


    public function checkStatus($id)
    {
        return Queue::find($id)->status;
    }

}