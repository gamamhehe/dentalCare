<?php

namespace App\Console\Commands;

use App\Helpers\AppConst;
use App\Helpers\Utilities;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Jobs\SendSmsJob;
use App\Model\Appointment;
use App\Model\Payment;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Log;

class RemindForgotAppt extends Command
{
    use AppointmentBussinessFunction;
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:forgotAppt';

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
     * @throws \SMSGatewayMe\Client\ApiException
     */
    public function handle()
    {
        Log::info("Run reminder forgot");
        $numDate = 1;
        $dateAgoObj = (new \DateTime())->modify('-' . $numDate . ' day');
        $listAppointmentAgo = (new Appointment)->whereDate('start_time', $dateAgoObj->format('Y-m-d'))
            ->where('status', AppConst::APPT_STATUS_CREATED)->get();
        $listPhone = [];
        foreach ($listAppointmentAgo as $appointmentAgo) {
            Log::info("Run reminder forgot");
            $appointmentPayment = (new Payment)->where('phone', $appointmentAgo->phone)
                ->where('status', AppConst::PAYMENT_STATUS_NOT_DONE)
                ->first();
            if ($appointmentPayment != null) {
                $listPhone [] = $appointmentAgo->phone;
                $appointmentAgo->status = AppConst::APPT_STATUS_SENT;
                $appointmentAgo->save();
            } else {
                $appointmentAgo->status = AppConst::APPT_STATUS_DELETED;
                $appointmentAgo->save();
            }
        }
        //send sms remind
        $listUniquePhone = array_unique($listPhone);
        foreach ($listUniquePhone as $phone) {
//            $this->dispatch(new SendSmsJob($phone, AppConst::MSG_REMINDER_FORGOT_APPOINTMENT));
            Log::info("SEND SMS REMIND FORGOT APP for: " . $phone);
        }


        ///remind pay for payment overdue 7 day
        $sevenDateAgoObj = (new \DateTime())->modify('-7 day');
        $listAppointment7DayAgo = (new Appointment)->whereDate('start_time', $sevenDateAgoObj->format('Y-m-d'))
            ->where('status', AppConst::APPT_STATUS_SENT)
            ->get();
        foreach ($listAppointment7DayAgo as $appointmentAgo) {
            $appointmentPayment = (new Payment)->where('phone', $appointmentAgo->phone)
                ->where('status', AppConst::PAYMENT_STATUS_NOT_DONE)
                ->first();
            if ($appointmentPayment != null) {
                Log::info("Cancel payment for phone: " . $appointmentPayment->phone);
                $appointmentPayment->status = AppConst::PAYMENT_STATUS_CANCEL;
                $appointmentPayment->save();
                $appointmentAgo->status = AppConst::APPT_STATUS_DELETED;
                $appointmentAgo->save();
            }
        }

    }
}
