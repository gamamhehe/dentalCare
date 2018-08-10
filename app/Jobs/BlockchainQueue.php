<?php

namespace App\Jobs;

use App\Http\Controllers\Blockchain\ClassCheckingStatus;
use App\Http\Controllers\BusinessFunction\NodeInfoBusinessFunction;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
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
//        $this->processFunction;
//        $this->createNewRecordInQueue('success_3',1,'127.0.0.1');
        $obj = new ClassCheckingStatus($this->data_encrypt);
        $obj->checkingStatusContinously();
    }


}

