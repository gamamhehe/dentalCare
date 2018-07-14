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

class CheckingThread extends \Thread
{
    use QueueBusinessFunction,BlockchainBusinessFunction,NodeInfoBusinessFunction;
    private $data_encrypt;
    //ip of the server that store the queue
    private $ip = '';

    public function __construct($ip, $data_encrypt)
    {
        $this->ip = $ip;
        $this->data_encrypt = $data_encrypt;
    }

    public function run()
    {
        $id = $this->addToAllNodeInNetWork($this->data_encrypt);
        while (true) {
            $status =$this->get_data($this->ip . '/checkStatus?id='.$this->id);
            if ($status != 'waiting') {
                $listNode = getListNode();
                foreach ($listNode as $node) {
                    $this->get_data($node->ip . '/createNewLedger?ip='.$this->ip);
                }
            }else if($status == 'done'){
                //Lấy sổ cái mới nhất
                $newestLedger = $this->getNewestDataJson();
                $this->sendToAll($newestLedger);
                break;
            }
            sleep(60 * 10);
        }
    }

    private function sendToAll($newestLedger){
        $listNode = $this->getListNode();
        foreach ($listNode as $node) {
            $ip = $node->ip;
            $url = $ip . '/createNewLedger?newest_ledger=' . $newestLedger; //the ip of current server
            $this->callTheURL($url);
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