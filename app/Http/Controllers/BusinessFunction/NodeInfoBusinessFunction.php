<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Absent;
use App\Model\NodeInfo;
use App\Model\Role;
use App\RequestAbsent;
use Carbon\Carbon;

trait NodeInfoBusinessFunction
{
    public function isExist($ip)
    {
        $check = NodeInfo::where('ip', '=', $ip)->first();
        if ($check != null) {
            return true;
        }
        return false;
    }

    public function getListNode()
    {
        $listNode = NodeInfo::all();
        return $listNode;
    }


    public function getLedger()
    {
        $url = '163.44.193.228/datajson';
        $data_encrypt = json_decode($this->get_data($url));
        $newestLedger = json_decode($this->get_data($url), true);
        return json_encode($newestLedger);
    }


    private
    function sendToAll($newestLedger)
    {
        $listNode = $this->getListNode();
        $currentIp = $_SERVER['REMOTE_ADDR'];
        foreach ($listNode as $node) {
            $ip = $node->ip;
            if ($ip != $currentIp) {
                $url = $ip . '/saveNewLedger?newest_ledger=' . $newestLedger; //the ip of current server
                $this->get_data($url);
            }
        }
    }


    private function get_data($url)
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
}