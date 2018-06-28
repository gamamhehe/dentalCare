<?php

namespace App\Http\Controllers\Mobile;

use App\Model\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class MobileController extends Controller
{

    /**
     *Dummy code to test laravel function
     * @GET
     * @param Request $request
     */
    public function test(Request $request)
    {
//        try {
//            $notification = new \stdClass();
//            $notification->title = 'Lonnn';
//            $notification->text = 'is is my text Tex';
//            $notification->click_action = 'android.intent.action.MAIN';
//
//            $data = new \stdClass();
//            $data->keyname = 'sss';
//
//
//            $requestObj = new \stdClass();
//            $requestObj->notification = $notification;
//            $requestObj->data = $data;
//            $requestObj->to = '/topics/all';
//            $client = new Client();
//            $request = $client->request('POST', 'https://fcm.googleapis.com/fcm/send',
//                [
//                    'body'=>json_encode($requestObj),
//                    'Content-Type' => 'application/json',
//                    'authorization'=>'key=AAAAUj5G2Bc:APA91bF8TkhDriuoevyt_I0G3G-qNniLSDdDHbULjcvsas4sHCuTKueiODRnuvVuYk6YkCHKLt3fr-Sw7UhZMzRSfmWMWzt2NZXzljYZxch39fg0v3NsBzQM5_QKUEy4bOdnnjigzaBX'
//                ]
//            );
////            $request->setBody($requestObj);
//            $response = $request->getBody()->getContents();
//            return response()->json($response);
//        } catch (GuzzleException $exception) {
//            return response()->json($exception->getMessage(), 500);
//        }

        $test = env('API_FIREBASE_SERVER_TOKEN',  false);
        return response()->json($test);
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
