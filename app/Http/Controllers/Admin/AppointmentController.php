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
        $newApp = $this->createAppointment($dateBooking, $phone, $request->note, $request->dentist_id,
            $patientId, date('H:i:s', mktime(0,$estimateTimeReal, 0)),"UNKNOW" );
        $dateTime = new DateTime($newApp->start_time);
        $smsMessage = AppConst::getSmsMSG($newApp->numerical_order, $dateTime);
        $this->dispatch(new SendSmsJob($phone, $smsMessage));
        return response()->json($newApp);
    }
    public function getListAppoinmentByPatient($id){

    }

}
