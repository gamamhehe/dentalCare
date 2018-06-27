<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 28-Jun-18
 * Time: 02:24
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    public function sendNotification(Request $request)
    {
        try {
            $type = $request->input("type");
            $body = $request->input("body");
            $title = $request->input("title");
            $message = $request->input("message");
            $token = $request->input("to");
            $requestObj = new \stdClass();

            $data = new \stdClass();
            $data->type = $type;
            $data->body = $body;
            $data->title = $title;
            $data->message = $message;


            $requestObj->data = $data;

            $requestObj->to = $token;

            $client = new Client();
            $request = $client->request('POST', 'https://fcm.googleapis.com/fcm/send',
                [
                    'body' => json_encode($requestObj),
                    'headers'=>[
                    'Content-Type' => 'application/json',
                    'authorization' => 'key=AAAAUj5G2Bc:APA91bF8TkhDriuoevyt_I0G3G-qNniLSDdDHbULjcvsas4sHCuTKueiODRnuvVuYk6YkCHKLt3fr-Sw7UhZMzRSfmWMWzt2NZXzljYZxch39fg0v3NsBzQM5_QKUEy4bOdnnjigzaBX'
                ]
                ]
            ); 
            $response = $request->getBody()->getContents();
            return response()->json($response);
        } catch (GuzzleException $ex) {
            $error = new \stdClass();
            $error->error = $ex->getTrace();
            $error->exception = $ex->getMessage() . " File: " . $ex->getFile() . " Line: " . $ex->getLine();
            return response()->json($error, 500);
        }
    }
}