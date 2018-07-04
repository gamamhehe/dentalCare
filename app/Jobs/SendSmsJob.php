<?php

namespace App\Jobs;

use App\Helpers\Utilities;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use SMSGatewayMe\Client\ApiException;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone, $message)
    {
        $this->phone = $phone;
        $this->message =$message;
    }

    protected $phone, $message;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            sleep(10);
//            $smsSendingResult =  Utilities::sendSMS($this->phone, $this->message);
//            $smsDecode = json_encode($smsSendingResult);
            Utilities::logDebug("HANDLE SendSmsJob test With sleep");
//            Utilities::logDebug("HANDLE SendSmsJob".$smsDecode);
        } catch (ApiException $e) {
            Log::info('SendSmsJob'.$e->getMessage());
        }

    }
}
