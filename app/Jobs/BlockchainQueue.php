<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\BusinessFunction\QueueBusinessFunction;
use App\Http\Controllers\BusinessFunction\BlockchainBusinessFunction;
use App\Model\Queue;

class BlockchainQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use QueueBusinessFunction, BlockchainBusinessFunction;
    protected $data_encrypt;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data_encrypt)
    {
        $this->data_encrypt = $data_encrypt;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        $id = $this->addToAllNodeInNetWork($this->data_encrypt);
        echo $id;
//        $status = Queue::find($id);
//        echo $status;
//        while (true) {
//
////            if ($status != 'waiting') {
////                $listNode = $this->getListNode();
////                foreach ($listNode as $node) {
////                    $this->get_data($node->ip . '/saveNewLedger?ip='.$this->ip);
////                }
//            if ($status == 2) {
//                //Lấy sổ cái mới nhất
//                $newestLedger = $this->getNewestDataJson();
//                $this->sendToAll($newestLedger);
//                break;
//            }
//            echo 1;
//            sleep(10);
//        }
    }

//    }

    private
    function sendToAll($newestLedger)
    {
        $listNode = $this->getListNode();
        foreach ($listNode as $node) {
            $ip = $node->ip;
            $url = $ip . '/saveNewLedger?newest_ledger=' . $newestLedger; //the ip of current server
            $this->callTheURL($url);
        }
    }

    private
    function get_data($url)
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

