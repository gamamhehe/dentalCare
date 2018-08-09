<?php

namespace App\Jobs;

use App\Http\Controllers\BusinessFunction\NodeInfoBusinessFunction;
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
//        $id = $this->addToAllNodeInNetWork($this->data_encrypt);
        $id = 2;
        $status = $this->checkStatus($id);
//            if ($status != 'waiting') {
//                $listNode = $this->getListNode();
//                foreach ($listNode as $node) {
//                    $this->get_data($node->ip . '/saveNewLedger?ip='.$this->ip);
//                }
        if ($status == 2) {
            //Lấy sổ cái mới nhất
            $newestLedger = $this->getNewestDataJson();
            $this->sendToAll($newestLedger);
        }
        sleep(2);
    }


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

