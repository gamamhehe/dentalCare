<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 05-Jul-18
 * Time: 10:37
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use Illuminate\Http\Request;

class TestController
{
    use UserBusinessFunction;
    use AppointmentBussinessFunction;
//   api/bacsiranh?date=
    public function getDentist(Request $request)
    {
        $date = $request->query('date');
        $listAvailableDentist = $this->getAvailableDentistAtDate($date);
        return response()->json($listAvailableDentist);
    }

    public function getToken($phone){

        $user = $this->getUserByPhone($phone);
        if($user==null){
            return "CANNOT find user with phone: " .$phone;
        }
//        return $user->createToken('android')->accessToken;
        $token = $user->createToken('MyToken')->accessToken;
        return  $token;
    }
}