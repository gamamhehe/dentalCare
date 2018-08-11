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

    public function checkLedger()
    {
        $ledger_1 = $this->callAPI_GetData('163.44.193.228');
        $ledger_2 = json_decode($this->convertDataToJson());

        if ($this->checkBlockChain($ledger_1) && $this->checkBlockChain($ledger_2))
            if (sizeof($ledger_1) < sizeof($ledger_2)) {
                if (($ledger_1[sizeof($ledger_1) - 1]->Hash) == ($ledger_2[sizeof($ledger_1)]->previousHash))
                    return $ledger_2;
            } else if (sizeof($ledger_1) > sizeof($ledger_2))
                if (($ledger_2[sizeof($ledger_2) - 1]->Hash) == ($ledger_1[sizeof($ledger_2)]->previousHash))
                    return $ledger_1;

        return "ERROR BLOCKCHAIN";
    }


    public function saveNewLedger(Request $request)
    {
        $newestLedger = $request->newest_ledger;
        return $this->saveNewAll($newestLedger);
    }

    public function test()
    {
        $ledger = $this->getLedger();
        $this->sendToAll($ledger);
    }
}