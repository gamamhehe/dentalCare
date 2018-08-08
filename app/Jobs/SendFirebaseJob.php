<?php

namespace App\Jobs;

use App\Helpers\Utilities;
use Hamcrest\UtilTest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SendFirebaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected  $requestObj;
    public function __construct($type,$title,$message,$body, $token)
    {
        $this->requestObj = Utilities::getFirebaseRequestObj($type, $title, $message, $body, $token);
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        Utilities::sendFirebase($this->requestObj);
        Log::info("Send firebase reload page for dentist: ");
    }
}
