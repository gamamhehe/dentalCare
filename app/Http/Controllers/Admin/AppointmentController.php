<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\AnamnesisBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Jobs\SendSmsJob;
use App\Model\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use DB;
use Response;
use App\Helpers\AppConst;
use Pusher\Pusher;

class AppointmentController extends Controller
{
    //
    use AppointmentBussinessFunction;
    use TreatmentHistoryBusinessFunction;
    use AnamnesisBusinessFunction;
    use UserBusinessFunction;
    use PatientBusinessFunction;
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
       try {
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
       } catch (\Exception $e) {
            return 0;
       }
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

    public function detailAppointmentById($appointId)
    {
        $appointment = $this->getAppointmentById($appointId);
        // $statusString = $appointment->status;
        if ($appointment->status == 0) {
            $appointment->statusString = "Vừa tạo";
        } else if ($appointment->status == 1) {
            $appointment->statusString = "Đã tạo";
        } else if ($appointment->status == 2) {
            $appointment->statusString = "Đang khám";
        } else if ($appointment->status == 3) {
            $appointment->statusString = "Đã khám xong";
        } else {
            $appointment->statusString = "Đã xóa";
        }
        $checkAppoint = $this->checkAppointmentExistPatient($appointId);
        $result = [];
        if ($checkAppoint == 0) {
            $patient = null;
        } else {
            $patient = Patient::where('id', $checkAppoint)->first();
            // $result =[];
            if ($patient) {
                $idPatient = $patient->id;
                $listTreatmentHistory = $this->getTreatmentHistory($idPatient);
                foreach ($listTreatmentHistory as $treatmentHistory) {
                    if ($treatmentHistory->finish_date == null) {
                        $result[] = $treatmentHistory;
                    }
                }

            } else {
            }
            $patient->Anamnesis = $this->getListAnamnesisByPatient($patient->id);

        }
          
        return view('admin.AppointmentPatient.detail', ['appointment' => $appointment, 'patient' => $patient, 'listTreatmentHistory' => $result]);
    }

    public function startAppointmentController($appointId)
    {
        $appointment = $this->getAppointmentById($appointId);
        $this->startAppointment($appointId);
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );
        $pusher = new Pusher(
            'e3c057cd172dfd888756',
            '993a258c11b7d6fde229',
            '562929',
            $options
        );
        $appointment->pushStatus = 1;
        $pusher->trigger('receivePatient', 'ReceivePatient', $appointment);
    }

    public function UserAppoinment(Request $request){
    try {
        $phone = $request['guestPhone'];
        if($phone==null){
           $phone =  $request['phoneNumber'];
        }
        $dateBooking = $request['start_date'];
        $errormess ="Lịch hẹn ngày ".$dateBooking." đã đầy";

        $note = $request['guestNote'];
        if($note == null){
            $note = "Không có";
        }

        $newformat = date('Y-m-d',strtotime($dateBooking));
        $newApp = $this->createAppointment($newformat, $phone, $note,null,
              null,null, $request->guestName);
        $numerical_order = $newApp->numerical_order;
        $start_time = $newApp->start_time;
        $successMess = "Số thứ tự :".$numerical_order.", Bắt đầu khám vào lúc : ".$start_time; 
        $dateTime = new DateTime($newApp->start_time);
        $smsMessage = AppConst::getSmsMSG($newApp->numerical_order, $dateTime);
        $this->dispatch(new SendSmsJob($phone, $smsMessage));
        return redirect()->back()->withSuccess($successMess);
       } catch (\Exception $e) {
          return redirect()->back()->withError($errormess);
       }
    }
}
