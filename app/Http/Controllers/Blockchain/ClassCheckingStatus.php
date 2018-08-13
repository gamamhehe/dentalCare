<?php
/**
 * Created by PhpStorm.
 * User: PhuNDSE63159
 * Date: 14-Jul-18
 * Time: 3:10 PM
 */

namespace App\Http\Controllers\Blockchain;


use App\Http\Controllers\BusinessFunction\BlockchainBusinessFunction;
use App\Http\Controllers\BusinessFunction\QueueBusinessFunction;
use App\Http\Controllers\Blockchain\BlockchainController;
use Illuminate\Support\Facades\Log;
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
        if (is_integer((int)$id)) {
            while (true) {
                $status = $this->checkStatus($id - 1);
                if ($status == 2) {
                    $newestLedger = json_decode($this->get_data('150.95.110.217/datajson'));
                    array_push($newestLedger, json_decode($this->dataEncrypt));
                    $this->saveNewAll($newestLedger);
                    $this->sendToAll();
                    $this->updateAllQueue($id);
                    return;
                }
                sleep(1);
            }
        }
        Log::info("ClassCheckingStatus_checkingStatusContinously_idNotInteger " . $id);
    }

    private
    function sendToAll()
    {
        $listNode = $this->getListNode();
        $host = gethostname();
        $serverIp = gethostbyname($host);
        foreach ($listNode as $node) {
            $ip = $node->ip;
            if ($serverIp != $ip) {
                $url = $ip . '/saveNewLedger';
                $result = $this->get_data($url);
                if ($result == 'fail') {
                    Log::info("ClassCheckingStatus_sendToAll_Error ");
                }
                Log::info($result);
            }
        }
    }


    private
    function get_data($url)
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->get($url);
        $data = $request->getBody()->getContents();
        return $data;
    }

}