<?php
/**
 * Created by PhpStorm.
 * User: PhuNDSE63159
 * Date: 14-Jul-18
 * Time: 3:10 PM
 */

namespace App\Http\Controllers\Blockchain;


use App\Http\Controllers\BusinessFunction\BlockchainBusinessFunction;
use App\Http\Controllers\BusinessFunction\NodeInfoBusinessFunction;
use App\Http\Controllers\BusinessFunction\QueueBusinessFunction;
use Spatie\Async\Task;

class ClassCheckingStatus
{
    use QueueBusinessFunction, BlockchainBusinessFunction;
    private $dataEncrypt;

    public function __construct($dataEncrypt)
    {
        $this->dataEncrypt = $dataEncrypt;
    }

    public function checkingStatusContinously()
    {
        $id = $this->addToAllNodeInNetWork($this->dataEncrypt);
        $result = '';
        if (is_integer((int)$id)) {
            while (true) {
                $status = $this->checkStatus($id - 1);
                if ($status == 2) {
                    $newestLedger = json_decode($this->get_data('150.95.110.217/datajson'));
                    array_push($newestLedger, json_decode($this->dataEncrypt));
                    $this->updateAllQueue($id);
                    $this->sendToAll(json_encode($newestLedger));
                    break;
                }
                sleep(2);
            }
        }
    }

    private
    function sendToAll($newestLedger)
    {
        $listNode = $this->getListNode();
        $currentIp = request()->ip();
        foreach ($listNode as $node) {
            $ip = $node->ip;
            if ($ip != $currentIp) {
                $url = $ip . '/saveNewLedger?newest_ledger=' . $newestLedger; //the ip of current server
                $this->callTheURL($url);
            }
        }
    }


    private
    function get_data($url)
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