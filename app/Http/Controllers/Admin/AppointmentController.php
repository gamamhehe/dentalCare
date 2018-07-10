<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Appointment;
use Carbon\Carbon;
use DB;
use Response;
class AppointmentController extends Controller
{
    //
    use AppointmentBussinessFunction;

    public function create(Request $request){

        $this->createAppointment($request->bookingDate,$request->phone,$request->note);
    }
    public function add(Request $request){
        $phone = $request['phone'];
        $estimateTimeReal=$request['estimateTimeReal'];
        $patientId = $request['patientID'];
        $dateBooking= $request['datepicker'];
        $startTime = strtotime($dateBooking);
        $xxx = date('Y-m-d H:i:s', $startTime);
        $dentist = $request->session()->get('currentAdmin', null);
        $dentist_id = $dentist->belongToStaff()->first()->id;
    	 DB::beginTransaction();
        try {
           	$newApp = new Appointment;
    	$newApp->start_time = $xxx;
    	$newApp->note = "NONO";
    	$newApp->estimated_time =$estimateTimeReal;
    	$newApp->numerical_order = 12;
        $newApp->phone = $phone;
    	$newApp->staff_id =$dentist_id;
    	$newApp->patient_id=$patientId;
        $newApp->save();
        DB::commit();
            return response()->json($newApp);

        } catch (\Exception $e) {
            DB::rollback();
             return "no";

        }

    

    }

}
