<?php

namespace App\Http\Controllers\Blockchain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BusinessFunction\BlockchainBusinessFunction;
use App\Model\Key;
use phpseclib\Crypt\RSA;
use App\Model\TreatmentHistory;
use App\Model\NodeInfo;

class BlockchainController extends Controller
{
    use BlockchainBusinessFunction;

    public function convertDataToJson(){
        $dataBlockchainObj = $this -> getDataBlockChain();
        return $dataBlockchainObj -> toJson();
    }

    public function getDataBlockchainJson(){
        $dataBlockchainJson = $this -> convertDataToJson();
        return response() -> json($dataBlockchainJson, 400);
    }

    public function callAPI_GetData() {
        $client = new \Guzzle\Service\Client('http://163.44.193.228/');
        $response = $client->get("datajson")->send();
        dd($response);
    }

}
