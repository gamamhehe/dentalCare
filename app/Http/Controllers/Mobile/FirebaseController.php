<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 28-Jun-18
 * Time: 02:24
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\Controller;
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
            $requestObj = new \stdClass();
            $user = $this->getUserByPhone($phone);
            if ($user == null) {
                $error = new \stdClass();
                $error->error = "Không thể tìm thấy số điện thoại";
                $error->exception = null;
                return response()->json($error, 400);
            }
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
            return response()->json($responseObj, 200);
        } catch (GuzzleException $ex) {
            $error = new \stdClass();
            $error->error = $ex->getTraceAsString();
            $error->exception = $ex->getMessage() . " File: " . $ex->getFile() . " Line: " . $ex->getLine();
            return response()->json($error, 500);
        }
    }
}