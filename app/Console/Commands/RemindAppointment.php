<?php

namespace App\Console\Commands;

use App\Helpers\Utilities;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Jobs\SendReminderJob;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Log;

class RemindAppointment extends Command
{
    use AppointmentBussinessFunction;
    use DispatchesJobs;
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
        $numOfReminder = 0;
        foreach ($appointments as $appointment) {
            $apptDateTime = (new \DateTime($appointment->start_time));
            if ($this->isUpCommingAppointment($currentDateTime, $apptDateTime)) {
                $numOfReminder++;
                Utilities::logInfo('RemindAppointment.handle(): Send for: ' .
                    $appointment->phone .
                    ' with appointment id: ' .
                    $appointment->id);
                $this->dispatch(new SendReminderJob($appointment));
            }
        }
        Utilities::logInfo("Remind: " . $numOfReminder . " appointments");
    }
}
