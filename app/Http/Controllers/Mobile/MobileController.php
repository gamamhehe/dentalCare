<?php

namespace App\Http\Controllers\Mobile;

use App\Helpers\Utilities;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
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
        $this->dispatch(new SendSmsJob("01678589696", "Hello nha"));
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
