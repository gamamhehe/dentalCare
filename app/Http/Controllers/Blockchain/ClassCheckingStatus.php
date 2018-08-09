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
    private $data_encrypt;

    public function __construct($data_encrypt)
    {
        $this->data_encrypt = $data_encrypt;
    }

    public function checkingStatusContinously()
    {
//            $id = $this->addToAllNodeInNetWork($this->data_encrypt);
//        $id = 2;
//        while (true) {
//            $status = $this->checkStatus($id);
//            if ($status == 2) {
//                //Tạo hash, preHash
//                //add vào blockchain
//                //Lấy sổ cái mới nhất
//                $newestLedger = $this->getNewestDataJson();
//                $this->sendToAll($newestLedger);
//                break;
//            }
//            sleep(2);
//        }
            $this->createNewRecordInQueue('success_2',1,'127.0.0.1');
    }

    private
    function sendToAll($newestLedger)
    {
        $listNode = $this->getListNode();
        foreach ($listNode as $node) {
            $ip = $node->ip;
            $url = $ip . '/saveNewLedger?newest_ledger=' . $newestLedger; //the ip of current server
            $this->callTheURL($url);
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