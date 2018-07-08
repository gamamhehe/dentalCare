<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 05-Jul-18
 * Time: 10:37
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use Illuminate\Http\Request;

class TestController
{
    use AppointmentBussinessFunction;
//   api/bacsiranh?date=
    public function getDentist(Request $request)
    {
        $date = $request->query('date');
        $listAvailableDentist = $this->getAvailableDentist($date);
        return response()->json($listAvailableDentist);
    }
}