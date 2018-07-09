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
//        //call firebase notify patient
//        $currentDateTime = new \DateTime();
//        $appointments = $this->getAppointmentsByStartTime($currentDateTime->format('Y-m-d'));
//        $currentTimeStamp = $currentDateTime->getTimestamp();
//        foreach ($appointments as $appointment) {
//            $apptDateTime = (new \DateTime($appointment->start_time));
//            $apptTimeStamp = $apptDateTime->getTimestamp();
//            if ($apptTimeStamp > $currentTimeStamp) {
//                if ($this->isUpCommingAppointment($currentDateTime, $apptDateTime)) {
//                    Utilities::logDebug("FIND ONCE" . $minute . " date in db: " . $tmpDateTime->format('Y-m-d H:i:s'));
//                    Utilities::sendRemindingAppointment($appointment->phone);
//                }
//            }
//        }
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

    public function test5(Request $request)
    {
        $date = $request->query('date');
        $data = '' . $this->getColumnTime();
        $listDentists = $this->getAvailableDentist($date);
        $numDentist = 1;
        foreach ($listDentists as $dentist) {
            $appointments = $this->getDentistApptAtDate($dentist->id, $date);
            $dentistTemplate = '<div style="float:left;width:100px">';
            foreach ($appointments as $appointment) {
                $templateAppointment =
                    $this->getApptTemplate(
                        $appointment,
                        $numDentist);
                $dentistTemplate .= $templateAppointment;
            }
            $dentistTemplate .= '</div>';
            $data .= $dentistTemplate . '</div>';
            $numDentist++;
        }
        $data .= '</div>';
        return $data;
    }

    public function testSMS($phone, $content)
    {
        $result = Utilities::sendSMS($phone, $content);
        return response()->json($result, 200);
    }

    public function getApptTemplate($appointment, $numDentist)
    {
        $standardDate = new DateTime($appointment->start_time);
        $standardDate->setTime(7, 0);
        $bookingDate = new DateTime($appointment->start_time);
        $estimatedTimeObj = new DateTime($appointment->estimated_time);
        $diff = $bookingDate->diff($standardDate);
        $hour = $diff->h;
        $minute = $diff->i;
        $startMinute = $hour * 60;
        $startMinute += $minute;

        $topPixel = $startMinute * 5;//1 minute = 5pixel;
        $leftPosition = $numDentist * 170;
        $heightPixel = (intval($estimatedTimeObj->format('i'))
                + intval($estimatedTimeObj->format('H') * 60)) * 5;
        $phone = intval($appointment->phone);
        $width = 150;
        $colorCodeR = ($phone) % 200 + 50;
        $colorCodeG = ($phone * 10) % 255;
        $colorCodeB = ($phone * 100) % 255;
        $textColor = '#000000';
//        $colorCodeR =  255;
//        $colorCodeG = 255;
//        $colorCodeB =   255;
        $bgcolor = 'rgb(' . $colorCodeR . ', ' . $colorCodeG . ', ' . $colorCodeB . ')';
//        $bgcolor = 'white';

        ///get column apointment
        $template = '<div style="position:absolute;top:' . $topPixel .
            'px;left:' . $leftPosition . 'px' .//background:' . $color .
            ';width:' . $width . 'px;height:' . $heightPixel . 'px;border:1px solid black;">' .
            ' <span style=" ;color:' . $textColor . '">' . $appointment->id . '</span>' .
            ' <span style=" ;color:' . $textColor . '">DentistID:' . $appointment->staff_id . '</span><br>' .
            '  <span style="background:' . $bgcolor . ';color:white">' . $appointment->phone . '</span><br>' .
            ' <span style=" ;color:' . $textColor . '">StartTime: ' . $bookingDate->format('H:i') . '</span> ' .
            '<span style=" ;color:' . $textColor . '">Estimate: ' . $appointment->estimated_time . '</span> ' .
            ' <span style=" ;color:' . $textColor . '">Order: ' . $appointment->numerical_order . '</span> ' .
            '</div>';

        return $template;

    }

    public function getColumnTime()
    {
        $date = new DateTime();

        $template = '<div style="float:left;width:100px">';
        for ($i = 0; $i < 840; $i += 30) {
            $bgColor = '#20d8b3';
            if ($i >= 300 && $i < 360) {
                $bgColor = '#333300';
            }
            $topPos = $i * 5;
            $heightPx = 30 * 5;
            $date->setTime(7 + intval(($i / 60)), $i % 60);
//            $this->logDebug("I " .(7 + intval(($i / 60))));
//            $this->logDebug(($date->format('H:i')));
            $template .= '<div style="border:1px solid white;position:absolute;top:'
                . $topPos .
                'px;background:'
                . $bgColor .
                ';width:100px;height:'
                . $heightPx .
                'px"><span style="color:#ffffff">StartAt:'
                . ($date->format('H:i')) .
                '</span> 
    </div>';
        }
        return ($template .= '</div>');
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

    public function topappt(Request $request)
    {
        $date = $request->query('date');
        $listDentsit = $this->getAvailableDentist($date);
        $listApps = $this->getListTopAppointment($listDentsit, $date);
        $response = new \stdClass();
        $response->numDentist = count($listDentsit);
        $response->numAppts = count($listApps);
        $response->appointments = $listApps;
        return response()->json($response);
    }


    public
    function testPOST(Request $request)
    {
        return response()->json("Success", 200);
    }
}
