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
        return response($dataBlockchainJson);
    }

    public function callAPI_GetData($IP){
        $client = new \GuzzleHttp\Client();

        // Create a request
        $request = $client->get('http://'. $IP .'/datajson');
        // Get the actual response without headers
        $response = $request->getBody()->getContents();
        $data = json_decode($response);

        return $data;
    }

    public function checkBlockChain($blockchain){
        if($blockchain[0] -> previousHash != 0)
            return false;
        for($i = 0; $i < sizeof($blockchain) - 1; $i++){
            if($blockchain[$i] -> Hash != $blockchain[$i+1] -> previousHash)
                return false;
        }
        return true;
    }

    public function compareBlockChain($blockchain_1, $blockchain_2, $blockchain_3){
        if($blockchain_1 == $blockchain_2)
            return $blockchain_1;
        else if($blockchain_2 == $blockchain_3)
            return $blockchain_2;
        else 
            return $blockchain_3;
    }

    public function checkLedger(){
        $nodeInfo = json_decode($this -> getNodeInfo());

        $ledger_1 = $this -> callAPI_GetData($nodeInfo[0] -> name);
        $ledger_2 = $this -> callAPI_GetData($nodeInfo[1] -> name);
        $ledger_3 = $this -> callAPI_GetData($nodeInfo[2] -> name);

        if($this -> checkBlockChain($ledger_1) && $this -> checkBlockChain($ledger_2))
            return $this -> compareBlockChain($ledger_1, $ledger_2, $ledger_3);
            
        return "ERROR BLOCKCHAIN";
    }

    public function setDataTypePayment(){
        $listStrings = array("5,2000000,50000000,01279011096,1,2017-08-08 20:00:00,1", "3, 60000000, 5, 2", "9, 4, 3, 2017-08-08 20:00:00, 222222, 3");
        $arrayString = explode ( ',' , $listStrings[0]);
        foreach($listStrings as $element){
            $arrayString = explode ( ',' , $element);
            if($arrayString[sizeof($arrayString) - 1] == 1)
                $this -> setDataCreatePayment($arrayString);
            else if($arrayString[sizeof($arrayString) - 1] == 2)
                $this -> setDataUpdatePayment($arrayString);
            else
                $this -> setDataPaymentDetail($arrayString);
        }
    }

}
