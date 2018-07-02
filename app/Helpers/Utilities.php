<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 02-Jul-18
 * Time: 11:24
 */

namespace App\Helpers;


use App\Model\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Model\SendMessageRequest;

class Utilities
{
    public static function sendSMS($phone, $message)
    {
        $config = Configuration::getDefaultConfiguration();
        $smsApiToken = env('SMS_API_TOKEN', false);
        $smsDeviceId = env('SMS_DEVICE_ID', false);
        $deviceNumber = env('SMS_DEVICE_NUMBER', false);
        $config->setApiKey('Authorization', $smsApiToken);
        $apiClient = new ApiClient($config);
        $messageClient = new MessageApi($apiClient);
        $order = 999;
//        $message = 'Cam on ban da dat lich, so thu tu cua ban la ' . $order;
        $sendMessageRequest1 = new SendMessageRequest([
            'phoneNumber' => $phone,
            'message' => $message,
            'deviceId' => $smsDeviceId
        ]);
        $sendMessages = $messageClient->sendMessages([
            $sendMessageRequest1
        ]);
        $result = json_decode($sendMessages[0]);
        return $result;
    }
    public static function sendRemindingAppointment($phone)
    {

        try {
            $type = "RESPONSE_REMINDER";
            $body = "Lịch hẹn của bạn sẽ diễn ra trong vòng 30 phút nữa";
            $title = "Nhắc nhở";
            $message = "Bạn có lịch hẹn";
            $requestObj = new \stdClass();
            $user = User::where ('phone', $phone)->first();
            if ($user == null) {
                self::logDebug('Firebase Appointment: Cannot find user with phone: ' . $phone);
                return "'Firebase Appointment: Cannot find user with phone: ' . $phone";
            } else if($user->noti_token == "NO_TOKEN") {
                self::logDebug("Firebase Appointment: user with phone ".$phone." Has NO_TOKEN");
                return "Firebase Appointment: user with phone ".$phone." Has NO_TOKEN";
            }else{
                $token = $user->noti_token;
                $data = new \stdClass();
                $data->type = $type;
                $data->body = $body;
                $data->title = $title;
                $data->message = $message;

                $requestObj->data = $data;
                $requestObj->to = $token;
                $firebaseServerToken = env('API_FIREBASE_SERVER_TOKEN', false);
                $client = new Client();
                $request = $client->request('POST', 'https://fcm.googleapis.com/fcm/send',
                    [
                        'body' => json_encode($requestObj),
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'authorization' => $firebaseServerToken
                        ]
                    ]
                );

                $response = $request->getBody()->getContents();
                $responseObj = json_decode($response);
                self::logDebug("Firebase Appointment:  Response is " . $responseObj);
                return $responseObj;
            }
        } catch (GuzzleException $ex) {
            self::logDebug("Firebase Appointment: Exception when sending firebase reminding appointment: " . $ex->getMessage());
            return $ex->getMessage();
        }
    }

    public static function logDebug($message)
    {
        Log::info($message);
    }

    public static function getErrorObj($message, $exception)
    {
        $error = new \stdClass();
        $error->error = $message;
        $error->exception = $exception;
        return $error;
    }
}