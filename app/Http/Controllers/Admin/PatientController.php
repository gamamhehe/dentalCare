<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Model\Patient;
use App\Model\Payment;
use App\Model\User;
use App\Model\UserHasRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    use UserBusinessFunction;
    use PatientBusinessFunction;
    use AppointmentBussinessFunction;

    public function login(Request $request)
    {

        $this->validate($request, [
            'phone' => 'required|min:10|max:11',
            'password' => 'required|min:6'
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
            return redirect()->back()->with('fail', '* You do not have permission for this page')->withInput($request->only('phone'));
        }
        return redirect()->back()->with('fail', '* Wrong phone number or password')->withInput($request->only('phone'));
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
            $userHasRole = new UserHasRole();
            $userHasRole->phone = $request->phone;
            $userHasRole->role_id = 4;
            $userHasRole->start_time = Carbon::now();
            $patient->name = $request->name;
            $patient->address = $request->address;
            $patient->phone = $request->phone;
            $patient->date_of_birth = $request->date_of_birth;
            $patient->gender = $request->gender;
            $patient->avatar = $request->avatar;
            $patient->district_id = $request->district_id;
            $patient->is_parent = $request->is_parent;
            $result = $this->createPatient($patient);

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
            $patient->avatar = $request->avatar;
            $patient->district_id = $request->district_id;
            $patient->is_parent = $request->is_parent;
            $user->phone = $user->phone;
            $user->password = Hash::make($user->phone);
            $result = $this->createUserWithRole($user, $patient, $userHasRole);
        }
        if ($result) {
            return redirect()->route("admin.Patient.create")->withSuccess("Sự kiện đã được tạo");
        } else {
            return redirect('admin/list-Event')->withSuccess("Sự kiện chưa được tạo");
        }
    }

    public function get($phone)
    {
        return $this->getPatient($phone);
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
        $appointment = $this->checkAppointmentForPatient($phone, $id);
        if ($appointment === false) {
            $status = 0;
        } else
            if ($appointment) {
                $appointment->patient_id = $id;
                $appointment->status = 1;
                $this->saveAppointment($appointment);
                $status = 1;
            } else {
                $status = 2;

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

        return view('admin.AppointmentPatient.index');
    }

    public function action1($phone)
    {
        $output = '';
        $user = $this->getUserByPhone($phone);
        if (!$user) {
            $total_row = -1;
            Session::flash('taikhoan', 'khongco');
            $output = '
       <tr>
        <td align="center" colspan="5">Không có tài khoản </td>
       </tr>
       ';
        } else {
            $data = DB::table('tbl_patients')
                ->where('phone', '=', $phone)
                ->orderBy('phone', 'desc')
                ->get();


            $total_row = $data->count();


            if ($total_row > 0) {
                Session::flash('taikhoan', '456');
                foreach ($data as $row) {
                    $output .= '
        <tr>
         <td style="width: 30%">' . $row->name . '</td>
         <td style="width: 30%">' . $row->address . '</td>
         <td style="width: 20%">' . $row->date_of_birth . '</td>
         <td align="center" style="width: 20%">
         <button type="button" class="btn btn-default btn-success"
                                 onclick="receive(' . $row->id . ')">Nhận bệnh nhân</button>
        </tr>
        ';
                }

            }
            if ($total_row == 0) {
                Session::flash('taikhoan', '123');
                $output = '
       <tr>
        <td align="center" colspan="5">Không có bệnh nhân </td>
       </tr>
       ';
            }

        }

        $data = array(
            'table_data' => $output,
            'total_data' => $total_row
        );
        echo json_encode($data);
    }
    public function changeAvatar(Request $request){
        $value = $request->session()->get('listPatient'); 
        $phone = $value[0]->phone;
        $listPatient = Patient::where('phone',$phone)->get();
        $request->session()->remove('listPatient');
        session(['listPatient' => $listPatient]);
        $image = $request['avatar'];
        $id = $request['patientID'];
        $result = $this->editAvatar($image,$id );
        return redirect('/myProfile');
    }
}
