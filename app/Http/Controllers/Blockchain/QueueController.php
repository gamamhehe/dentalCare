<?php

namespace App\Http\Controllers\Blockchain;

use App\Http\Controllers\BusinessFunction\NodeInfoBusinessFunction;
use App\Http\Controllers\BusinessFunction\QueueBusinessFunction;
use App\Jobs\BlockchainQueue;
use App\Model\Blockchain;
use App\Model\NodeInfo;
use App\Model\Queue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function MongoDB\BSON\toJSON;

class QueueController extends Controller
{

    use QueueBusinessFunction;
    public function addToQueue(Request $request)
    {
        $data_encrypt = $request->data_encrypt;
        $status = 1; // 1 là waiting, 2 là  done
        $ip = $request->ip;
        return $this->createNewRecordInQueue($data_encrypt, $status, $ip);
    }


    public function checkStatusOfRecord(Request $request)
    {
        $id = $request->id;
        return $this->checkStatus($id);
    }

    public function threadQueue(Request $request){
        $data_encrypt = $request->data_encrypt;
        BlockchainQueue::dispatch($data_encrypt);
    }
//
//    public function checkExist(Request $request){
//        return json_encode($this->isExist($request->ip));
//    }

}
