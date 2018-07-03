<?php

namespace App\Http\Controllers\Mobile;

use App\Helpers\Utilities;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
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
//call firebase notify patient
//        $currentDateTime = new \DateTime();
//        $appointments = $this->getAppointmentsByStartTime($currentDateTime->format('Y-m-d'));
//        $currentTimeStamp = $currentDateTime->getTimestamp();
//        foreach ($appointments as $appointment){
//            $tmpDateTime = (new \DateTime($appointment->start_time));
//            $tmpTimeStamp =$tmpDateTime->getTimestamp();
//            if($tmpTimeStamp > $currentTimeStamp){
//                $minute = $tmpDateTime->diff($currentDateTime)->i;
//                $this->logDebug("MINUTE ".$minute);
//                if($minute<=30 && $minute>=26){
//                    Utilities::logDebug("FIND ONCE".$minute." date in db: " . $tmpDateTime->format('Y-m-d H:i:s'));
//                    Utilities::sendRemindingAppointment($appointment->phone);
//
//                    return response()->json("SEND SUCCESS");
//
//
//                }
//            }
//        }
//        $date = Carbon::now()->format('Y-m-d H:i:s');
//        $appointment = new Appointment();
//        $appointments = $appointment
//            ->whereDate(
//            'start_time', '=', Carbon::now()->format("Y-m-d"))
//            ->where (
//                'start_time', '>=', Carbon::now()->format("Y-m-d H:i:s")
//            )
//            ->get();
////        $appointments->dateNow = Carbon::now()->format("Y-m-d H:i:s");
////        $listDentist = $this->getFreeDentistsFromTime(Carbon::now(),new \DateTime('2018-07-03 13:00:00'));
//        $predictAppointmentDate = new \DateTime("2018-07-03 12:20:20");
//        $currentDateTime = new \DateTime();
//        $diffDate = ($currentDateTime->diff($predictAppointmentDate)) ;
////        var_dump($appointments);
//        $app = $this->getLastestAppointment('2018-07-03', 1);
        try {
            $app = $this->createAppointment(
                '2018-07-03',
                '10968574849',
                'no',
                4,
                '00:59:00');
//        $listDentist = $this->getAvailableDentist((new \DateTime())->format('Y-m-d'));
//       $app= $this->getListTopAppointment($listDentist,(new \DateTime())->format('Y-m-d'));
            return response()->json($app);
        }catch (\Exception $exception){
            return response()->json(['ex' =>$exception->getMessage()]);
        }

    }

    public function tests2(Request $request)
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
    public function testPOST(Request $request)
    {
        return response()->json("Success", 200);
    }
}
