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
    	 DB::beginTransaction();
        try {
           	$newApp = new Appointment;
    	$newApp->start_time = Carbon::now();
    	$newApp->note = "NONO";
    	$newApp->estimated_time =Carbon::now();
    	$newApp->numerical_order = 12;
        $newApp->phone = "019";
    	$newApp->staff_id =1;
    	$newApp->patient_id=1;
        $newApp->save();
        DB::commit();
            return response()->json($newApp);

        } catch (\Exception $e) {
            DB::rollback();
            
             return "no";

        }

    

    }

}
