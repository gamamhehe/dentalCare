<?php

namespace App\Http\Controllers\Admin;

use App\Events\ReceiveAppointment;
use App\Helpers\AppConst;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\AnamnesisBusinessFunction;
use App\Http\Controllers\Mobile\BaseController;
use App\Jobs\SendFirebaseJob;
use App\Model\FirebaseToken;
use App\Model\Patient;
use App\Model\Payment;
use App\Model\AnamnesisCatalog;
use App\Model\User;
use App\Model\District;
use App\Model\City;
use App\Model\UserHasRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;
use DB;
use DateTime;
use Pusher\Pusher;
use App\Http\Controllers\Controller;

class PatientController extends BaseController
{

    use AppointmentBussinessFunction;
    use TreatmentHistoryBusinessFunction;
    use AnamnesisBusinessFunction;
    use UserBusinessFunction;
    use PatientBusinessFunction;


    public function login(Request $request)
    {

        $this->validate($request, [
            'phone' => 'required|min:10|max:11',
            'password' => 'required|min:6|max:11',
        ]);
        $user = $this->checkLogin($request->phone, $request->password);

        if ($user != null) {
            $roleID = $user->hasUserHasRole()->first()->belongsToRole()->first()->id;
            if ($roleID == 4) {

                session(['currentUser' => $user]);

                $listPatient = $user->hasPatient()->get();
                if (count($listPatient) > 0) {
                    session(['listPatient' => $listPatient]);
                    session(['currentPatient' => $listPatient[0]]);
                }
                return redirect()->intended(route('homepage'));
            }
            return redirect()->back()->with('fail', 'Bạn không được phép truy cập ')->withInput($request->only('phone'));
        }
        return redirect()->back()->with('fail', 'Tài khoản sai thông tin')->withInput($request->only('phone'));
    }

    public function changeCurrentPatient(Request $requet, $id)
    {
        $requet->session()->remove('currentPatient');
        $patient = $this->getPatientById($id);
        session(['currentPatient' => $patient]);

        return redirect()->intended(route('homepage'));
    }
    public function createPatientWeb(Request $request){
         $checkExist = $this->checkExistUser($request->phone);
        if ($checkExist) {

            return 0;//da ton tai
        } else {
            $patient = new Patient();
            $userHasRole = new UserHasRole();
            $user = new User();
            $userHasRole->phone = $request->phone;
            $userHasRole->role_id = 4;
            $userHasRole->start_time = Carbon::now();
            $patient->name = $request->name;
            $patient->address = $request->address;
            $patient->phone = $request->phone;
            $patient->date_of_birth = (new Carbon($request->date_of_birth))->format('Y-m-d H:i:s');
            $patient->gender = $request->gender;
            $patient->avatar = " http://150.95.104.237/assets/images/avatar/default_avatar.jpg";
            $patient->district_id = $request->district_id;
            $user->phone = $request->phone;
            $address ="";
            $city = $patient->belongsToDistrict()->first()->belongsToCity()->first()->name;
            $district = $patient->belongsToDistrict()->first()->name;
            $address = $patient->address." ".$district .", ".$city;
            $patient->address=  $address;
            $user->password = Hash::make($user->phone);
            $result = $this->createUserWithRole($user, $patient, $userHasRole);
        }
        if ($result) {
            $listAnamnesis = $request->anam;
            if($listAnamnesis !=null){
                $result2 = $this->createAnamnesisForPatient($listAnamnesis, $patientID);
            }
            return 1;
        } else {
            return 2;
        }
    }
    public function create(Request $request)
    {
        $checkExist = $this->checkExistUser($request->phone);
        $listAnamnesis = $request->anam;
        if ($checkExist) {
            $patient = new Patient();
            $userHasRole = new UserHasRole();
            $userHasRole->phone = $request->phone;
            $userHasRole->role_id = 4;
            $userHasRole->start_time = Carbon::now();
            $patient->name = $request->name;
            $patient->address = $request->address;
            $patient->phone = $request->phone;
            $patient->avatar = " http://150.95.104.237/assets/images/avatar/default_avatar.jpg";
            $patient->date_of_birth = (new Carbon($request->date_of_birth))->format('Y-m-d H:i:s');
            $patient->gender = $request->gender;
            $patient->district_id = $request->district_id;
            $address ="";
            $city = $patient->belongsToDistrict()->first()->belongsToCity()->first()->name;
            $district = $patient->belongsToDistrict()->first()->name;
            $address = $patient->address." ".$district .", ".$city;
            $patient->address=  $address;
            $result = $this->createPatient($patient);
            if ($result != false) {
                if($listAnamnesis !=null){
                  $result2 = $this->createAnamnesisForPatient($listAnamnesis, $result);
                }
                return redirect()->back()->withSuccess("Bệnh nhân đã được tạo");
            }else{
                 return redirect()->back()->withSuccess("Bệnh nhân chưa được tạo");
            }
        } else {
            $patient = new Patient();
            $userHasRole = new UserHasRole();
            $user = new User();
            $userHasRole->phone = $request->phone;
            $userHasRole->role_id = 4;
            $userHasRole->start_time = Carbon::now();
            $patient->name = $request->name;
            $patient->address = $request->address;
            $patient->phone = $request->phone;
            $patient->date_of_birth = (new Carbon($request->date_of_birth))->format('Y-m-d H:i:s');
            $patient->gender = $request->gender;
            $patient->avatar = " http://150.95.104.237/assets/images/avatar/default_avatar.jpg";
            $patient->district_id = $request->district_id;
            $address ="";
            $city = $patient->belongsToDistrict()->first()->belongsToCity()->first()->name;
            $district = $patient->belongsToDistrict()->first()->name;
            $address = $patient->address." ".$district .", ".$city;
            $patient->address=  $address;
            $user->phone = $request->phone;
            $user->password = Hash::make($user->phone);
            if($listAnamnesis != null){
                 $result = $this->createUserWithAnamnesis($user, $patient, $userHasRole,$listAnamnesis);
            }else{
                 $result = $this->createUserWithRole($user, $patient, $userHasRole);
            }
           
             if ($result) {
                    return redirect()->back()->withSuccess("Bệnh nhân đã được tạo");
                } else {
                   return redirect()->back()->withSuccess("Bệnh nhân chưa được tạo");
                }
        }
       
    }
    public function getCityForDistrict(){
        $city = City::all();
        return $city;
    }
    public function get($phone)
    {
        return $this->getPatientByPhone($phone);
    }

    public function update(Request $request)
    {
        $patient = $this->getPatientById($request->patient_id);
        $patient->name = $request->name;
        $patient->address = $request->address;
        $patient->phone = $request->phone;
        $patient->date_of_birth = $request->date_of_birth;
        $patient->gender = $request->gender;
        $patient->avatar = $request->avatar;
        $patient->district_id = $request->district_id;
        $patient->is_parent = $request->is_parent;
        $this->updatePatient($patient);

    }

    public function getList()
    {
        return $this->getListPatient();
    }


    public function receive($id)
    {
        $phone = $this->getPhoneOfPatient($id);
        $isExamination = $this->checkPatientIsExamination($id);
        if ($isExamination) {
            $status = -1;
        } else {
            $appointment = $this->checkAppointmentForPatient($phone, $id);
            if ($appointment === null) {
                $status = 2;
            } else{
                    $appointment->status = 1;
                    $this->saveAppointment($appointment, $id);
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
                    $appointment->pushStatus = 0;
                    $pusher->trigger('receivePatient', 'ReceivePatient', $appointment);
                    $this->sendFirebaseReloadMobile($appointment->staff_id, AppConst::ACTION_RELOAD_DENTIST_APPOINTMENT);
                    $status = 1;
        }}
        $data = array(
            'statusOfReceive' => $status
        );

        echo json_encode($data);
    }

    public function listAppointment($id)
    {

        return view('admin.AppointmentPatient.list');
    }

    public function index()
    {
        $city = city::all();
        $District = District::where('city_id', 1)->get();
        $patientList = Patient::all();
        $listAnamnesis = AnamnesisCatalog::all();
        $RoleDentist = UserHasRole::where('role_id','2')->get();
        $dentist=[];
        foreach ($RoleDentist as $key ) {
            $dentist[] = $key->belongsToUser()->first()->belongToStaff()->first();
        }
        // foreach ($patientList as $patient) {
        //      $address ="";
        //     $patient->cityDetail = $patient->belongsToDistrict()->first()->belongsToCity()->first()->name;
        //     $patient->disctrictDetail = $patient->belongsToDistrict()->first()->name;
        //     $address = $patient->address."  $patient->disctrictDetail  " ."  ,$patient->cityDetail";
        //      $patient->address=  $address;
        // }
        return view('admin.AppointmentPatient.index', ['AnamnesisCatalog' => $listAnamnesis, 'citys' => $city, 'District' => $District, 'patientList' => $patientList,'dentists'=>$dentist]);
    }

    public function action1($valueSearch)
    {
        $output = '';
        if ($valueSearch == 'all') {
            $data = Patient::all();
             
        } else {
            $data = DB::table('tbl_patients')
                ->where('phone', 'like', $valueSearch . '%')
                ->orWhere('name', 'like', '%' . $valueSearch . '%')
                ->orderBy('name', 'desc')
                ->get();

        }
        $total_row = $data->count();
        if ($total_row > 0) {
            Session::flash('taikhoan', '456');
            foreach ($data as $row) {
                $output .= '
        <tr>
         <th  style="text-align: center; " class="col-lg-2 col-md-2 col-sm-2 col-xs-2  ">' . $row->name . '</th>
         <th   style="text-align: center; " class="col-lg-1 col-md-1 col-sm-1 col-xs-1  ">' . $row->phone . '</th>
         <th  style="text-align: center; " class="col-lg-3 col-md-3 col-sm-3 col-xs-3 ">' . $row->address . '</th>
         <th  style="text-align: center; " class="col-lg-1 col-md-1 col-sm-1 col-xs-1  ">' . $row->date_of_birth . '</th>
         <th  style="text-align: center; " class="col-lg-3 col-md-3 col-sm-3 col-xs-3 ">
            <a href="thong-tin-benh-nhan/' . $row->id . '" class="btn btn-default btn-info">Thông tin bệnh nhân</a>
            <button type="button" class="btn btn-default btn-success"
                                 onclick="receive(' . $row->id . ')">Nhận bệnh nhân</button>
                                 </th>
        </tr>
        ';
            }

        }
        if ($total_row == 0) {
            $output = '
       <tr>
        <td align="center" colspan="5">Không có bệnh nhân </td>
       </tr>
       ';
        }


        $data = array(
            'table_data' => $output,
            'total_data' => $total_row
        );
        echo json_encode($data);
    }

    public function changeAvatar(Request $request)
    {
        $value = $request->session()->get('listPatient');
        $phone = $value[0]->phone;
        $listPatient = Patient::where('phone', $phone)->get();
        $request->session()->remove('listPatient');
        session(['listPatient' => $listPatient]);
        $image =  $request->file('avatar');
        dd($image);
        $id = $request['patientID'];
        $result = $this->editAvatar($image, $id);
        return redirect('/myProfile');
    }

    public function getListPatientById($id)
    {
        $list = $this->getPatientByPhone($id);
        return response()->json($list);


    }

    public function getDistrictbyCity($id)
    {
        $listDistrict = District::where('city_id', $id)->get();
        return $listDistrict;
    }

    public function getInfoPatientById($id)
    {
        $patient = Patient::where('id', $id)->first();
        $result = null;
        if ($patient) {
            $idPatient = $patient->id;
            $result = $this->getTreatmentHistory($idPatient);
        }
        $anam = $this->getListAnamnesisByPatient($id);
        $appClosest = $this->getAppointmentByPhoneFutureClosest($patient->phone);
                $start_time ="Không có lịch hẹn";
                if($appClosest !=null){
                    $start_time =  $appClosest->start_time;
        }
        if ($anam == null) {
            $anam = "Không có";
        }else{
            $size = count($anam);
            $anamString = "Không có";

            if($size>0){
                  for ($i=0; $i < count($anam) ; $i++) { 
                       if($i==0){
                        $anamString =  $anam[$i]->name;
                       }else{
                        $anamString =  $anamString." - ". $anam[$i]->name ;
                       }
                    }
                    $anamString = $anamString ." . ";
                   
            }
        }
        if(count($result) == 0){
            $result = null;
        }
        return view('admin.Patient.detail', ['Anamnesis' => $anamString, 'patient' => $patient, 'listTreatmentHistory' => $result,'appFuture'=>$start_time]);

    }

    public function detailAppoinmentById($appointId)
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
        $patientFinal = [];
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

        return view('admin.Patient.Treat', ['appointment' => $appointment, 'patient' => $patient, 'listTreatmentHistory' => $result]);
    }
}
