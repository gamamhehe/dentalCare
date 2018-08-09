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
    protected $processFunction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($processFunction)
    {
        $this->processFunction = $processFunction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        $this->processFunction;
    }


}

