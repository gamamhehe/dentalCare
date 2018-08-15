<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 06-Jul-18
 * Time: 21:27
 */

namespace App\Http\Controllers\Mobile;


use App\Helpers\AppConst;
use App\Http\Controllers\Controller;
use App\Jobs\SendFirebaseJob;
use App\Model\FirebaseToken;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class BaseController extends Controller
{
    public function getErrorObj($message, $exceptionObj)
    {
        $error = new \stdClass();
        $error->error = $message;
        $error->exception = $this->getExceptionMsg($exceptionObj);
        return $error;
    }

    public function getSuccessObj($code, $status, $message, $data)
    {
        $successResponse = new \stdClass();
        $successResponse->code = $code;
        $successResponse->status = $status;
        $successResponse->message = $message;
        $successResponse->data = $data;
        return $successResponse;
    }

    public function getExceptionMsg($exceptionObj)
    {
        $message = "No exception";
        if ($exceptionObj != null && is_object($exceptionObj)) {
            $message = 'Message: ' . ($exceptionObj->getMessage())
                . ' File: ' . $exceptionObj->getFile()
                . ' Line: ' . $exceptionObj->getLine();
        }
        return $message;
    }

    public function logInfo($message){
        Log::info("MyLOG: " . $message);
    }

    public function sendFirebaseReloadMobile($staffId, $registedAction)
    {
        $staff = $this->getStaffById($staffId);
        if ($staff != null) {
            $this->logInfo("Staff !=null reload");
            $staffFirebaseToken = FirebaseToken::where('phone', $staff->phone)->first();
            if ($staffFirebaseToken != null) {
                $this->logInfo("Staff firebase !=null reload");

                $this->dispatch(new SendFirebaseJob(AppConst::RESPONSE_RELOAD,
                        $staff->id,
                        "No message",
                        $registedAction,
                        $staffFirebaseToken->noti_token)
                );
            }
            $this->logInfo("Send sendFirebaseReloadAppointment func");
        } else {
            $this->logInfo("staff in sendFirebaseReloadAppointment null");
        }
    }

    public function updateNumAppWebsite($appointment)
    {
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );
        $pusher = new Pusher(
            'e3c057cd172dfd888756',
            '993a258c11b7d6fde229',
            '562929',
            $options
        );
        $appointment->pushStatus = 0;
        $pusher->trigger('receivePatient', 'ReceivePatient', $appointment);
    }
}