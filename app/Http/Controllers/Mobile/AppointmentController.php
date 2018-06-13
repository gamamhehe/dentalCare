<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 12-Jun-18
 * Time: 21:56
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\Controller;
use http\Env\Request;

class AppointmentController extends Controller
{
    use AppointmentBussinessFunction;

    public function bookAppointment(Request $request)
    {
        $phone = $request->input('phone');
        $note = $request->input('note');
        $bookingDate = $request->input('date_booking');
        $appointment = $this->createAppointment($phone, $note, $bookingDate);
        if ($appointment != null) {
            return response()->json($appointment, 200);
        } else {

            $error = new \stdClass();
            $error->error = "Get appointment null from server";
            $error->exception = "No exception";
            return response()->json($error, 400);
        }
    }
}