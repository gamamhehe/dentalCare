<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Jobs\SendSmsJob;
use App\Model\Patient;
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

    public function testFunction(Request $request)
    {
        $client = new \GuzzleHttp\Client();

// Create a request
        $request = $client->get('http://163.44.193.228/datajson');
// Get the actual response without headers
        $response = $request->getBody()->getContents();
        return $response;
    }

    public function add(Request $request)
    {
        $phone = $request['phone'];
        $estimateTimeReal = $request['estimateTimeReal'];
        $patientId = $request['patientID'];
        $dateBooking = $request['datepicker'];
        $sessionAdmin = $request->session()->get('currentAdmin', null);
        $role = $sessionAdmin->hasUserHasRole()->first()->belongsToRole()->first()->id;
        $patientName = Patient::where('id', $patientId)->first()->name;
        $newformat = date('Y-m-d',strtotime($dateBooking));
        if ($role == 2) {
            $staff_id = $sessionAdmin->belongToStaff()->first()->id;
            $newApp = $this->createAppointment($newformat, $phone, $request->note, $staff_id,
                $patientId, date('H:i:s', mktime(0, $estimateTimeReal, 0)), $patientName);
        } else {
            $newApp = $this->createAppointment($newformat, $phone, $request->note, null,
                $patientId, date('H:i:s', mktime(0, $estimateTimeReal, 0)), $patientName);
        }
        $dateTime = new DateTime($newApp->start_time);
        $smsMessage = AppConst::getSmsMSG($newApp->numerical_order, $dateTime);
        $this->dispatch(new SendSmsJob($phone, $smsMessage));
        return response()->json($newApp);
    }
    public function getListAppoinmentByPatient($id){

    }


    public function checkDone($appointmentId){
        $status = $this->checkDoneAppointment($appointmentId);
        $data = array(
            'statusDone' => $status,
        );
        echo json_encode($data);
    }
}
