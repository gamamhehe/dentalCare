<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\AnamnesisBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Jobs\SendSmsJob;
use App\Model\Patient;
use App\Model\Staff;
use App\Model\City;
use App\Model\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use DB;
use App\Model\AnamnesisCatalog;
use Response;
use App\Helpers\AppConst;
use Pusher\Pusher;
use Carbon\Carbon;
use App\Model\UserHasRole;

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
        \DB::statement('ALTER TABLE tbl_payments AUTO_INCREMENT = 1000;');
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
                $patientId, date('H:i:s', mktime(0, $estimateTimeReal, 0)), $patientName,true);
        } else {
            $newApp = $this->createAppointment($newformat, $phone, $request->note, null,
                $patientId, date('H:i:s', mktime(0, $estimateTimeReal, 0)), $patientName,true);
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
        $listPatient = [];
        $case3 = 0;
        $dentist= null; $dentist = $appointment->belongsToStaff()->first();
        if ($checkAppoint == 0) {//khong có lịch hẹn.

            $resultPatient = $this->getPatientByPhone($appointment->phone);

            if($resultPatient){
                if(count($resultPatient)==0){//co acc chưa có patient
                     $patient = null;
                }
                else{
                    $patient =$resultPatient[0];
                    $listPatient = $resultPatient;
                }
               
            }else{
                $patient = null;
            }
        } else {// có lịch hẹn
           
            $case3 = 1;
            $patient = Patient::where('id', $checkAppoint)->first();
            // $result =[];
            if ($patient) {// bệnh nhân tồn tại
                $idPatient = $patient->id;
                $listTreatmentHistory = $this->getTreatmentHistory($idPatient);
                foreach ($listTreatmentHistory as $treatmentHistory) {
                    if ($treatmentHistory->finish_date == null) {
                        $result[] = $treatmentHistory;
                    }
                }

            } else { // bệnh nhân không tồn tại.

            }
            $patient->Anamnesis = $this->getListAnamnesisByPatient($patient->id);

        }
        $city = city::all();
        $District = District::where('city_id', 1)->get();
        $listAnamnesis = AnamnesisCatalog::all(); 
       
        return view('admin.AppointmentPatient.detail', ['appointment' => $appointment, 'citys' => $city, 'District' => $District,'patient' => $patient, 'listTreatmentHistory' => $result,'AnamnesisCatalog' => $listAnamnesis,'listPatient'=>$listPatient,'case3'=>$case3,'dentist'=>$dentist]);
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

        $checkNewMember = $this->checkNewMember($phone);


        $resultAccount = $this->createAccountNewMember($phone);
        if($resultAccount == false){
               return redirect()->back()->withError("Có lỗi khi đặt lịch");
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
        if($checkNewMember==true){
            $this->dispatch(new SendSmsJob($phone, AppConst::getSmsNewUser()));
        }
        return redirect()->back()->withSuccess($successMess);
       } catch (\Exception $e) {
          return redirect()->back()->withError($errormess);
       }
    }
    public function applyAppointment(Request $request){
        //tao benh nhan
            $patient = new Patient();
            $listAnamnesis = $request->anam;
            $patient->name = $request->name;
            $patient->address = $request->address;
            $patient->phone = $request->phone;
            $patient->avatar = " http://150.95.104.237/assets/images/avatar/default_avatar.jpg";
            $patient->date_of_birth = (new Carbon($request->date_of_birth))->format('Y-m-d H:i:s') ;
            $patient->gender = $request->gender;
            $patient->district_id = $request->district_id;
            $patientID = $this->ư($patient);
            if($patientID ==false){
                return false;
            }
            $result = $this->createAnamnesisForPatient($listAnamnesis,$patientID);
            if($result == false){
                return false;
            }
        // POA
            $appointId = $request->appId;
            $resultPOA = $this->AppointmentOfPatient($patientID,$appointId);
            if($resultPOA ==false){
                return false;
            }
        //status
            $resultStatus = $this->ư(1,$appointId);
            return redirect()->back()->withSuccess("Done");

    }
    public function applyAppointmentExistPatient(Request $request){
            $patientID = $request->patientID;
            $appointId = $request->appID;
            $resultPOA = $this->AppointmentOfPatient($patientID,$appointId);
            if($resultPOA ==false){
                return false;
            }
        //status
            $resultStatus = $this->updateStatusAppoinment(1,$appointId);
            return redirect()->back()->withSuccess("Done");
    }
    public function applyAppointmentWithStatus(Request $request){
        $appointId = $request->appID;
        $resultStatus = $this->updateStatusAppoinment(1,$appointId);
        return redirect()->back()->withSuccess("Done");
    }
    public function getFreeDentist(){
        $list = $this->getCurrentFreeDentist();
        $listObj =[];
        foreach ($list as $dentist=>$key) {
             $x = Staff::find($key);
              $listObj[]=$x;
        }
       return $listObj;
    }
    public function changeDentist(Request $request){
        $id =$request->docID;
        $appID=$request->appointmentID;
        $result = $this->updateDentistAppoinment($id,$appID);
        if($result==false){
            return 0;
        }
         return 1;
    }
}
