<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Jobs\SendSmsJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Appointment;
use Carbon\Carbon;
use DateTime;
use DB;
use function MongoDB\BSON\toJSON;
use Response;
use App\Helpers\AppConst;
class AppointmentController extends Controller
{
    //
    use AppointmentBussinessFunction;

    public function testFunction(Request $request){
        $client = new \GuzzleHttp\Client();

// Create a request
        $request = $client->get('http://163.44.193.228/datajson');
// Get the actual response without headers
        $response = $request->getBody()->getContents();
        return $response;
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
        // $smsMessage = AppConst::getSmsMSG($result->numerical_order, $startDateTime);
        // $this->dispatch(new SendSmsJob($phone, $smsMessage));
            return response()->json($newApp);

        } catch (\Exception $e) {
            DB::rollback();
             return $e;

        }

    
//
//=======
//        $formatDate = (new \DateTime($dateBooking))->format('Y-m-d');
//        $newApp = $this->createAppointment($formatDate, $request->phone, $request->note, $request->dentist_id,
//            $patientId, date('H:i:s', mktime(0,$estimateTimeReal, 0)));
//        $dateTime = new DateTime($newApp->start_time);
//        $smsMessage = AppConst::getSmsMSG($newApp->numerical_order, $dateTime);
//        $this->dispatch(new SendSmsJob($phone, $smsMessage));
//        return response()->json($newApp);
//>>>>>>> 4b8681fe961cb19a89fa36a0283f996dcaaaf368
    }

}
