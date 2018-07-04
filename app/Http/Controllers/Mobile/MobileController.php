<?php

namespace App\Http\Controllers\Mobile;

use App\Helpers\Utilities;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Jobs\SendReminderJob;
use App\Jobs\SendSmsJob;
use App\Model\Appointment;
use App\Model\Patient;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Model\SendMessageRequest;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Thread;

class MobileController extends Controller
{

    use AppointmentBussinessFunction;

    /**
     *Dummy code to test laravel function
     * @GET
     * @param Request $request
     */
    public function test(Request $request)
    {
        $id = $request->query('id');
        $appointment = $this->getAppointmentById($id);
        if ($appointment != null) {
            $crrDate = new DateTime();
            $appDate = new DateTime($appointment->start_time);
            if ($this->isUpCommingAppointment($crrDate, $appDate)) {
                return response()->json($appDate->format("Y-m-d H:i:s"));
            }
        }
        return response()->json('-__-');
    }

    public function handle()
    {
        //call firebase notify patient
        $currentDateTime = new \DateTime();
        $appointments = $this->getAppointmentsByStartTime($currentDateTime->format('Y-m-d'));
        $currentTimeStamp = $currentDateTime->getTimestamp();
        foreach ($appointments as $appointment) {
            $apptDateTime = (new \DateTime($appointment->start_time));
            $apptTimeStamp = $apptDateTime->getTimestamp();
            if ($apptTimeStamp > $currentTimeStamp) {
                if ($this->isUpCommingAppointment($currentDateTime, $apptDateTime)) {
                    Utilities::logDebug("FIND ONCE" . $minute . " date in db: " . $tmpDateTime->format('Y-m-d H:i:s'));
                    Utilities::sendRemindingAppointment($appointment->phone);
                }
            }
        }
    }

    public function getSastifyAppointmentDate()
    {
        $currentDate = new DateTime();
        $currentDate2 = new DateTime();
        $this->addTimeToDate($currentDate, '00:26:00');
        $this->addTimeToDate($currentDate2, '00:30:00');
        return "Time 1: " . $currentDate->format('Y-m-d H:i:s') . '<br> Date 2: ' . $currentDate2->format('Y-m-d H:i:s');

    }

    public function test2(Request $request)
    {
        return $this->getSastifyAppointmentDate();
    }

    public function test3(Request $request)
    {
        $id = $request->query('id');
        $appointment = $this->getAppointmentById($id);
        if ($appointment != null) {
            $crrDate = new DateTime();
            $appDate = new DateTime($appointment->start_time);
            if ($this->isUpCommingAppointment($crrDate, $appDate)) {
                return response()->json($appDate->format("Y-m-d H:i:s"));
            }
        }
        return response()->json('-__-');
    }

    public function test4()
    {
        //call firebase notify patient
        $currentDateTime = new \DateTime();
        $appointments = $this->getAppointmentsByStartTime($currentDateTime->format('Y-m-d'));
        $numOfReminder = 0;
        $apss = [];
        foreach ($appointments as $appointment) {
            $apptDateTime = (new \DateTime($appointment->start_time));
            if ($this->isUpCommingAppointment($currentDateTime, $apptDateTime)) {
                $numOfReminder++;
                Utilities::logDebug('Send for appointment id: ' . $appointment->id);
                $this->dispatch(new SendReminderJob($appointment->phone));
                $apss[] = $appointment;
            }
        }
        return response()->json($apss);
    }

        public
        function tests22(Request $request)
        {// Configure client
            $config = Configuration::getDefaultConfiguration();
            $smsApiToken = env('SMS_API_TOKEN', false);
            $smsDeviceId = env('SMS_DEVICE_ID', false);
            $deviceNumber = env('SMS_DEVICE_NUMBER', false);
            $config->setApiKey('Authorization', $smsApiToken);
            $apiClient = new ApiClient($config);
            $messageClient = new MessageApi($apiClient);
            $order = 999;
            $message = 'Cam on ban da dat lich, so thu tu cua ban la ' . $order;
            $sendMessageRequest1 = new SendMessageRequest([
                'phoneNumber' => $deviceNumber,
                'message' => $message,
                'deviceId' => $smsDeviceId
            ]);
            $sendMessageRequest2 = new SendMessageRequest([
                'phoneNumber' => '07791064781',
                'message' => 'Cam on ban da dat lich, so thu tu cua ban la ' . $order,
                'deviceId' => 95056
            ]);
            $sendMessages = $messageClient->sendMessages([
                $sendMessageRequest1
            ]);
            $result = json_decode($sendMessages[0]);
            return response()->json($result);
        }

        /**
         *Dummy code to test laravel function
         * @POST
         * @param Request $request
         */
        public
        function testPOST(Request $request)
        {
            return response()->json("Success", 200);
        }
    }
