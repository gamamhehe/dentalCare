<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    //
    use AppointmentBussinessFunction;

    public function createAppointmentController(Request $request){

        $this->createAppointment($request->bookingDate,$request->phone,$request->note);
    }

}
