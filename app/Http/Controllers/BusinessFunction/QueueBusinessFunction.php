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

trait QueueBusinessFunction
{
    use NodeInfoBusinessFunction;
    //Nguyen Dinh Phu. Last edit: 14-Jul-18
    public function createNewRecordInQueue($data_encrypt, $status, $ip)
    {
        $checkExistIp = $this->isExist($ip);
        if ($checkExistIp == true) {
            DB::beginTransaction();
            try {
                $id = Queue::create(['data_encrypt' => $data_encrypt, 'status' => $status, 'ip' => $ip,])->id;
                DB::commit();
                return $id;
            } catch (\Exception $e) {
                DB::rollback();
                return false;
            }
        }
        return null;
    }

    public function addToAllNodeInNetWork($data_encrypt)
    {
        $currentIp = $_SERVER['HOSTNAME']; //dd($_SERVER) for more details
        $listNode = $this->getListNode();
        foreach ($listNode as $node) {
            $ip = $node->ip;
            $url = $ip . '/addToQueue?data_encrypt=' . $data_encrypt . '&ip=' . $currentIp; //the ip of current server
            $this->callTheURL($url);
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

    public function getStatus($id)
    {
        return Queue::find($id)->status;
    }


}