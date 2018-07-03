<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 28-Jun-18
 * Time: 02:24
 */

namespace App\Http\Controllers\Mobile;


use App\Helpers\Utilities;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    use UserBusinessFunction;

    public function sendNotification(Request $request)
    {
        try {
            $type = $request->input("type");
            $body = $request->input("body");
            $title = $request->input("title");
            $message = $request->input("message");
            $phone = $request->input("phone");
            $user = $this->getUserByPhone($phone);
            if ($user == null) {
                $error = new \stdClass();
                $error->error = "Không thể tìm thấy số điện thoại";
                $error->exception = null;
                return response()->json($error, 400);
            }
            $token = $user->noti_token;
            $requestObj = Utilities::getFirebaseRequestObj($type, $title, $message, $body, $token);
            $response = Utilities::sendFirebase($requestObj);
            $responseObj = json_decode($response);
            return response()->json($responseObj, 200);
        } catch (Exception $ex) {
            $error = new \stdClass();
            $error->error = $ex->getTraceAsString();
            $error->exception = $ex->getMessage() . " File: " . $ex->getFile() . " Line: " . $ex->getLine();
            return response()->json($error, 500);
        }
    }

    public function remindAppointment(Request $request)
    {
        $phone = $request->input('phone');
        $response = Utilities::sendRemindingAppointment($phone);
        return response()->json($response);
    }
}