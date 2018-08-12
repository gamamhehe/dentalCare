<?php

namespace App\Http\Controllers\Blockchain;

use App\Http\Controllers\BusinessFunction\BlockchainBusinessFunction;
use App\Http\Controllers\BusinessFunction\NodeInfoBusinessFunction;
use App\Model\Blockchain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Key;
use phpDocumentor\Reflection\Types\Array_;
use phpseclib\Crypt\RSA;
use App\Model\TreatmentHistory;
use App\Model\NodeInfo;
use App\Http\Controllers\BusinessFunction\QueueBusinessFunction;


class BlockchainController extends Controller
{
    use BlockchainBusinessFunction;

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
        if ($blockchain[0]->previousHash != 0)
            return false;
        for ($i = 0; $i < sizeof($blockchain) - 1; $i++) {
            if ($blockchain[$i]->Hash != $blockchain[$i + 1]->previousHash)
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

    public function checkLedger()
    {
        $ledger_1 = $this->callAPI_GetData('163.44.193.228');
        $ledger_2 = $this->callAPI_GetData('150.95.110.217');
        $ledger_3 = $this->callAPI_GetData('150.95.108.108');

        if ($this->checkBlockChain($ledger_1) && $this->checkBlockChain($ledger_2)
            && $this->checkBlockChain($ledger_3))
            return $this->compareBlockChain($ledger_1, $ledger_2, $ledger_3);

        return "ERROR BLOCKCHAIN";
    }


    public function saveNewLedger(Request $request)
    {
        $newestLedger = $request->newest_ledger;
        return $this->saveNewAll($newestLedger);
    }

    public function test(Request $request)
    {
        $dataEncrypt = $request->data_encrypt;
        $newestLedger = json_decode($this->get_data('150.95.110.217/datajson'));
        array_push($newestLedger, json_decode($dataEncrypt));
        return json_encode($newestLedger);
    }
}