<?php

namespace App\Console\Commands;

use App\Helpers\Utilities;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RemindAppointment extends Command
{
    use AppointmentBussinessFunction;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:appointment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       //call firebase notify patient
        $currentDateTime = new \DateTime();
        $appointments = $this->getAppointmentsByStartTime($currentDateTime->format('Y-m-d'));
        $currentTimeStamp = $currentDateTime->getTimestamp();
        foreach ($appointments as $appointment){
            $tmpDateTime = (new \DateTime($appointment->start_time));
            $tmpTimeStamp =$tmpDateTime->getTimestamp();
            if($tmpTimeStamp > $currentTimeStamp){
                $minute = $tmpDateTime->diff($currentDateTime);
                if($minute<=30 && $minute>=26){
                    Utilities::logDebug("FIND ONCE".$minute." date in db: " . $tmpDateTime->format('Y-m-d H:i:s'));
                    Utilities::sendRemindingAppointment($appointment->phone);
                }
            }
        }
    }
}
