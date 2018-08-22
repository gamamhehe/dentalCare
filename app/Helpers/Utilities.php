<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 02-Jul-18
 * Time: 11:24
 */

namespace App\Helpers;


use App\Jobs\SendFirebaseJob;
use App\Jobs\SendSmsJob;
use App\Model\FirebaseToken;
use App\Model\Patient;
use App\Model\Staff;
use App\Model\TreatmentDetail;
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
     * @param $tmHistoryId
     */
    public function sendFeedback($tmHistory)
    {

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
            $fbToken = FirebaseToken::where('phone', $phone)->first();
            if ($fbToken == null) {
                self::logInfo('Firebase Appointment: Cannot find user with phone: ' . $phone);
                return "'Firebase Appointment: Cannot find user with phone: ' . $phone";
            } else if ($fbToken->noti_token == "NO_TOKEN") {
                self::logInfo("Firebase Appointment: user with phone " . $phone . " Has NO_TOKEN");
                return "Firebase Appointment: user with phone " . $phone . " Has NO_TOKEN";
            } else {
                $token = $fbToken->noti_token;
                $requestObj = self::getFirebaseRequestObj($type, $title, $message, $body, $token);
                $response = self::sendFirebase($requestObj);
                self::logInfo("Firebase Appointment:  Request is " . json_decode($requestObj));
                $responseObj = json_decode($response);
                self::logInfo("Firebase Appointment:  Response is " . $response);
                return $responseObj;
            }
        } catch (\Exception $ex) {
            self::logInfo("Firebase Appointment: Exception when sending firebase reminding appointment: " . $ex->getMessage()
            . " File: ". $ex->getFile() . " Line: " . $ex->getLine()
            );
            return $ex->getMessage();
        }
    }

    public static function logInfo($message)
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

    public static function getFeedbackObject($dentistName, $patientId, $treatmentDetailId, $dentistAvatar, $treatmentName, $createdDate)
    {
        $fbObject = new \stdClass();
        $fbObject->dentist_name = $dentistName;
        $fbObject->patient_id = $patientId;
        $fbObject->treatment_detail_id = $treatmentDetailId;
        $fbObject->dentist_avatar = $dentistAvatar;
        $fbObject->treatment_name = $treatmentName;
        $fbObject->created_date = $createdDate;
        return $fbObject;
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
            Log::info("Error send firebase " . $ex->getMessage());
            throw new Exception($ex);
        }
    }

    public static function getErrorObj($message, $exception)
    {
        $error = new \stdClass();
        $error->error = $message;
        $error->exception = self::getExceptionMsg($exception);
        return $error;
    }

    public static function getExceptionMsg($exceptionObj)
    {
        $message = "No exception";
        if ($exceptionObj != null && is_object($exceptionObj)) {
            $message = 'Message: ' . ($exceptionObj->getMessage())
                . ' File: ' . $exceptionObj->getFile()
                . ' Line: ' . $exceptionObj->getLine();
        }
        return $message;
    }

    public static function saveFile($file, $publicPath, $saveName)
    {
        try {
            $filename = $saveName . '.' . $file->getClientOriginalExtension();
            //get time stamp
            $path = public_path($publicPath);
            $date = new \DateTime();
            $timestamp = $date->getTimestamp();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $fullPath = implode('/',
                    array_filter(
                        explode('/', $publicPath . $filename))
                ) . '?time=' . $timestamp;
            $file->move($path, $filename);
            return $fullPath;
        } catch (Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public static function generateRandomString($source, $length = 8)
    {
        $characters = $source;
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}