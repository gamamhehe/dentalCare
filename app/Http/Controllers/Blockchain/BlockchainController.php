<?php

namespace App\Http\Controllers\Blockchain;

use App\Http\Controllers\BusinessFunction\BlockchainBusinessFunction;
use App\Http\Controllers\BusinessFunction\NodeInfoBusinessFunction;
use App\Model\Blockchain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Key;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Array_;
use phpseclib\Crypt\RSA;
use App\Model\TreatmentHistory;
use App\Model\NodeInfo;
use App\Http\Controllers\BusinessFunction\QueueBusinessFunction;


class BlockchainController extends Controller
{
    use BlockchainBusinessFunction, QueueBusinessFunction;

    private $clientIp;

    public function __construct()
    {
        $this->clientIp = \request()->ip();
    }


    public function convertDataToJson()
    {
        $dataBlockchainObj = $this->getDataBlockChain();
        return $dataBlockchainObj->toJson();
    }

    public function getDataBlockchainJson()
    {
        $dataBlockchainJson = $this->convertDataToJson();
        return response($dataBlockchainJson);
    }

    public function callAPI_GetData($IP)
    {
        $client = new \GuzzleHttp\Client();
        // Create a request
        $request = $client->get('http://' . $IP . '/datajson');
        // Get the actual response without headers
        $response = $request->getBody()->getContents();
        $data = json_decode($response);

        return $data;
    }

    public function checkBlockChain($blockchain)
    {
        if ($blockchain[0]->previous_hash != 0)
            return false;
        for ($i = 0; $i < sizeof($blockchain) - 1; $i++) {
            if ($blockchain[$i]->hash != $blockchain[$i + 1]->previous_hash)
                return false;
        }
        return true;
    }

    public function compareBlockChain($blockchain_1, $blockchain_2, $blockchain_3)
    {
        if ($blockchain_1 == $blockchain_2)
            return $blockchain_1;
        else if ($blockchain_2 == $blockchain_3)
            return $blockchain_2;
        else
            return $blockchain_3;
    }


    public function saveNewLedger(Request $request)
    {
        if ($this->isExist($this->clientIp)) {
            $newestLedger = $this->callTheURL($this->clientIp . '/getThisLedger');
            if ($newestLedger != 'fail')
                return $this->saveNewAll(json_decode($newestLedger));
        }
        Log::info('BlockchainController_SaveNewLedger_ClientIpNotInNetwork: ' . $this->clientIp);
        return 'fail';
    }

    public function getThisLedger()
    {
        if ($this->isExist($this->clientIp)) {
            $result = Blockchain::all();
            return json_encode($result);
        }
        Log::info('BlockchainController_getThisLedger_ClientIpNotInNetwork: ' . $this->clientIp);
        return 'fail';
    }

    public function test(Request $request)
    {
        $dataEncrypt = $request->data_encrypt;
        $id = $request->id;
        $host = gethostname();
        $ip = gethostbyname($host);
        if ($dataEncrypt != null) {
            $url = $ip . '/runJobQueue?data_encrypt=' . $dataEncrypt;
            $result = $this->callTheURL($url);
            echo $result;
        } else if ($id != null) {
            $url = $ip . '/updateAll?id=' . $id;
            $result = $this->callTheURL($url);
            echo $result;
        }
//        $newestLedger = json_decode($this->callTheURL('150.95.110.217/datajson'));
//        array_push($newestLedger, json_decode($dataEncrypt));
//        return json_encode($newestLedger);
    }

    public function testPerformance()
    {
        $dataEncrypt = '{"data_encrypt":"TaiGay","previous_hash":"ThongNatDit","hash":"TuongAnTaiTro"}';
        $listNode = $this->getListNode();
        for ($i = 0; $i <= 10; $i++) {
            $j = rand() % count($listNode);
            $url = $listNode[$j]->ip . '/test?data_encrypt=' . $dataEncrypt;
            $client = new \GuzzleHttp\Client();
            $client->get($url);
        }
        return 'feeling';
    }

    public function checkLedger()
    {
        $nodeInfo = $this->getNodeInfo();

        $ledger_1 = $this->callAPI_GetData($nodeInfo[0]->ip);
        $ledger_2 = $this->callAPI_GetData($nodeInfo[1]->ip);
        $ledger_3 = $this->callAPI_GetData($nodeInfo[2]->ip);

        if ($this->checkBlockChain($ledger_1) && $this->checkBlockChain($ledger_2))
            return $this->compareBlockChain($ledger_1, $ledger_2, $ledger_3);

        return "ERROR";
    }

    public function setDataTypePayment()
    {
        $listStrings = array("5,2000000,50000000,01279011096,1,2017-08-08 20:00:00,1", "3, 60000000, 5, 2", "9, 4, 3, 2017-08-08 20:00:00, 222222, 3");
        $arrayString = explode(',', $listStrings[0]);
        foreach ($listStrings as $element) {
            $arrayString = explode(',', $element);
            if ($arrayString[sizeof($arrayString) - 1] == 1)
                $this->setDataCreatePayment($arrayString);
            else if ($arrayString[sizeof($arrayString) - 1] == 2)
                $this->setDataUpdatePayment($arrayString);
            else
                $this->setDataPaymentDetail($arrayString);
        }
    }

}
