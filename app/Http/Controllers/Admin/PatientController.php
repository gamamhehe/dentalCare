<?php

namespace App\Http\Controllers\Admin;

use App\Events\ReceiveAppointment;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\AnamnesisBusinessFunction;
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
use Session;
use DB;
use Pusher\Pusher;
use App\Http\Controllers\Controller;

class PatientController extends Controller
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
                session(['listPatient' => $listPatient]);

                session(['currentPatient' => $listPatient[0]]);
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

    public function create(Request $request)
    {
        $checkExist = $this->checkExistUser($request->phone);
        if ($checkExist) {
            $patient = new Patient();
            $listAnamnesis = $request->anam;
            $userHasRole = new UserHasRole();
            $userHasRole->phone = $request->phone;
            $userHasRole->role_id = 4;
            $userHasRole->start_time = Carbon::now();
            $patient->name = $request->name;
            $patient->address = $request->address;
            $patient->phone = $request->phone;
            $patient->avatar = " http://150.95.104.237/assets/images/avatar/default_avatar.jpg";
            $patient->date_of_birth = $request->date_of_birth;
            $patient->gender = $request->gender;
            $patient->district_id = $request->district_id;
            $patientID = $this->createPatient($patient);
            if($patientID ==false){
                  return redirect('admin/live-seach')->withSuccess("Bệnh nhân chưa được tạo");
            }
            $result = $this->createAnamnesisForPatient($listAnamnesis,$patientID);
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
            $patient->date_of_birth = $request->date_of_birth;
            $patient->gender = $request->gender;
            $patient->avatar = " http://150.95.104.237/assets/images/avatar/default_avatar.jpg";
            $patient->district_id = $request->district_id;
            $user->phone = $request->phone;
            $user->password = Hash::make($user->phone);
            $result = $this->createUserWithRole($user, $patient, $userHasRole);
        }
        if ($result) {
            return redirect()->route("admin.AppointmentPatient.index")->withSuccess("Bệnh nhân đã được tạo");
        } else {
            return redirect('admin/live-seach')->withSuccess("Bệnh nhân chưa được tạo");
        }
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
            } else
                if ($appointment) {
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

                    $pusher->trigger('receivePatient', 'ReceivePatient', $appointment);
                    $status = 1;
                } else {
                    $status = 0;
//
                }
        }
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
        return view('admin.AppointmentPatient.index', ['AnamnesisCatalog' => $listAnamnesis, 'citys' => $city, 'District' => $District, 'patientList' => $patientList]);
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
         <td>' . $row->name . '</td>
         <td>' . $row->phone . '</td>
         <td>' . $row->address . '</td>
         <td>' . $row->date_of_birth . '</td>
         <td>
            <a href="thong-tin-benh-nhan/' . $row->id . '" class="btn btn-default btn-info">Thông tin bệnh nhân</a>
            <button type="button" class="btn btn-default btn-success"
                                 onclick="receive(' . $row->id . ')">Nhận bệnh nhân</button>
           
                                 </td>
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
        $image = $request['avatar'];
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
        $result = [];
        if ($patient) {
            $idPatient = $patient->id;
            $result = $this->getTreatmentHistory($idPatient);
        }
        $anam= $this->getListAnamnesisByPatient($id);
        if($anam == null){
            $anam ="Không có";
        }
        return view('admin.Patient.detail',['Anamnesis'=>$anam,'patient'=>$patient,'listTreatmentHistory'=>$result]);
         
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
