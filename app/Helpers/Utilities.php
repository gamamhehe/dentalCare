<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 02-Jul-18
 * Time: 11:24
 */

namespace App\Helpers;


use App\Model\User;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Model\SendMessageRequest;

class Utilities
{
    /**
     * @param $phone
     * @param $message
     * @return mixed
     * @throws \SMSGatewayMe\Client\ApiException
     */
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

    /**
     * @param $phone
     * @return mixed|string
     */
    public static function sendRemindingAppointment($appointment)
    {
        try {
            $phone = $appointment->phone;
            $startTime = (new DateTime($appointment->start_time))->format('H:i:s');

            $type = AppConst::RESPONSE_REMINDER;
            $body = AppConst::MSG_REMINDER_APPOINTMENT;
            $title = "Nhắc nhở cuộc hẹn";
            $message = "Bạn có cuộc hẹn ngày hôm nay vào lúc " . $startTime;
            $user = User::where('phone', $phone)->first();
            if ($user == null) {
                self::logDebug('Firebase Appointment: Cannot find user with phone: ' . $phone);
                return "'Firebase Appointment: Cannot find user with phone: ' . $phone";
            } else if ($user->noti_token == "NO_TOKEN") {
                self::logDebug("Firebase Appointment: user with phone " . $phone . " Has NO_TOKEN");
                return "Firebase Appointment: user with phone " . $phone . " Has NO_TOKEN";
            } else {
                $token = $user->noti_token;
                $requestObj = self::getFirebaseRequestObj($type, $title, $message, $body, $token);
                $response = self::sendFirebase($requestObj);
                $responseObj = json_decode($response);
                self::logDebug("Firebase Appointment:  Response is " . $response);
                return $responseObj;
            }
        } catch (Exception $ex) {
            self::logDebug("Firebase Appointment: Exception when sending firebase reminding appointment: " . $ex->getMessage());
            return $ex->getMessage();
        }
    }

    public static function logDebug($message)
    {
        Log::info($message);
    }

    /**
     * @param $type : get from AppConst
     * @param $title
     * @param $message
     * @param $body
     * @param $token : id token of mobile, get from database with field 'noti_token'
     * @return \stdClass
     */
    public static function getFirebaseRequestObj($type, $title, $message, $body, $token)
    {
        $reminderObj = new \stdClass();
        $data = new \stdClass();
        $data->type = $type;
        $data->body = $body;
        $data->title = $title;
        $data->message = $message;
        $reminderObj->data = $data;
        $reminderObj->to = $token;
        return $reminderObj;
    }

    /**
     * @param $requestObject
     * @return string
     * @throws Exception
     */
    public static function sendFirebase($requestObject)
    {
        try {
            $firebaseServerToken = env('API_FIREBASE_SERVER_TOKEN', false);
            $client = new Client();
            $request = $client->request('POST', 'https://fcm.googleapis.com/fcm/send',
                [
                    'body' => json_encode($requestObject),
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'authorization' => $firebaseServerToken
                    ]
                ]
            );
            $response = $request->getBody()->getContents();
            return $response;
        } catch (GuzzleException $ex) {
            throw new Exception($ex);
        }
    }

    public static function getErrorObj($message, $exception)
    {
        $error = new \stdClass();
        $error->error = $message;
        $error->exception = $exception;
        return $error;
    }

    public static function saveFile($file,$publicPath, $saveName)
    {
        try {
            $filename = $saveName . '.' . $file->getClientOriginalExtension();
            $hostname = request()->getHttpHost();
            //get time stamp
            $path = public_path($publicPath);
            $date = new \DateTime();
            $timestamp = $date->getTimestamp();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $fullPath = 'http://' . implode('/',
                    array_filter(
                        explode('/', $hostname.$publicPath .  $filename))
                ) . '?time=' . $timestamp;
            $file->move($path, $filename);
            return $fullPath;
        } catch (Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}