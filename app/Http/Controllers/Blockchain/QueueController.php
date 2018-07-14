<?php

namespace App\Http\Controllers\Blockchain;

use App\Http\Controllers\BusinessFunction\NodeInfoBusinessFunction;
use App\Http\Controllers\BusinessFunction\QueueBusinessFunction;
use App\Model\Blockchain;
use App\Model\NodeInfo;
use App\Model\Queue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QueueController extends Controller
{
    //Add new record to queue and waiting for processing
    //Nguyen Dinh Phu. Last edit: 14-Jul-18
    use QueueBusinessFunction;
    public function addToQueue(Request $request)
    {
        $data_encrypt = $request->data_encrypt;
        $status = "waiting";
        $ip = $request->ip;
        return $this->createNewRecordInQueue($data_encrypt, $status, $ip);
    }


    //check status of the record after add to queue
    //Nguyen Dinh Phu. Last edit: 12-Jul-18
    public function checkStatusOfRecord(Request $request)
    {
        $id = $request->id;
        return $this->getStatus($id);
    }

}
