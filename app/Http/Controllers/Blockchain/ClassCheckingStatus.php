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
use App\Model\Blockchain;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Object_;
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
                    $newestLedger = $this->createNewBlock();
                    $this->saveNewAll($newestLedger);
                    $this->sendToAll();
                    $this->updateAllQueue($id);
                    return;
                }
                sleep(0.1);
            }
        }
        Log::info("ClassCheckingStatus_checkingStatusContinously_idNotInteger " . $id);
    }

    private function createNewBlock()
    {
        $blockchainController = new BlockchainController();
        $newestLedger = $blockchainController->checkLedger();
        $hash = $blockchainController->HashOfBlock($this->dataEncrypt, '0');
        $size = sizeof($newestLedger);
        $lastestHash = '0';
        if ($size > 0) {
            $hash = $blockchainController->HashOfBlock($this->dataEncrypt, $newestLedger[$size - 1]->hash);
            $lastestHash = $newestLedger[$size - 1]->hash;
        }
        $obj = new Blockchain();
        $obj->data_encrypt = $this->dataEncrypt;
        $obj->previous_hash = $lastestHash;
        $obj->hash = $hash;
        array_push($newestLedger, $obj);
        return $newestLedger;
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