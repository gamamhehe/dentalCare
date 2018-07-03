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

    public function changeCurrentPatient(Request $requet,$id){
        $requet->session()->remove('currentPatient');
        $patient = $this->getPatientById($id);
        session(['currentPatient' => $patient]);

        return redirect()->intended(route('homepage'));
    }
    public function createBoth(Request $request){

        $checkExist = $this->checkExistUser($request->phone);
        if ($checkExist) {
            return false;
        }
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
        $this->createUserWithRole($user, $patient, $userHasRole);
    }

    public function create(Request $request)
    {
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
        $result= $this->createPatient($patient, $userHasRole);
        if($result){

            return redirect()->route("admin.Patient.create")->withSuccess("Sự kiện đã được tạo");
        }else{
            return redirect('admin/list-Event')->withSuccess("Sự kiện chưa được tạo");
        }
    }

    public function get($phone)
    {
        return $this->getPatient($phone);
    }

    public function update(Request $request)
    {
        $patient  = $this->getPatientById($request->patient_id);
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

    public function receive(Request $request)
    {
        $appointment = $this->checkAppointmentForPatient('01279011096', '2');
        if ($appointment) {
            $appointment->patient_id = 5;
            $appointment->is_coming = true;
            $this->saveAppointment($appointment);
        } else {
            return false;
        }
    }
    public function listAppointment($id){
        dd($id);
        return view('admin.AppoinmentPatient.list');
    }
     public function index()
    {

        return view('admin.AppoinmentPatient.index');
    }
    public function action1($xx){
        $output = '';
        $user = $this->getUserByPhone($xx);
        if(!$user){
             $total_row = -1;
              Session::flash('taikhoan', 'khongco');
            $output = '
       <tr>
        <td align="center" colspan="5">Không có tài khoản </td>
       </tr>
       ';
        }else{
             $data = DB::table('tbl_patients')
            ->where('phone', '=',$xx)
            ->orderBy('phone', 'desc')
            ->get();


        $total_row = $data->count();
 

        if($total_row > 0)
        {
            Session::flash('taikhoan', '456');
            foreach($data as $row)
            {
                $output .= '
        <tr>
         <td>'.$row->name.'</td>
         <td>'.$row->address.'</td>
         <td>'.$row->date_of_birth.'</td>
         <td><a href="list-Appointment/'.$row->id.'" class="btn btn-info" role="button">Lịch hẹn</a></td>
        </tr>
        ';
            }
         
        }
        if($total_row==0)
        {
            Session::flash('taikhoan', '123');
            $output = '
       <tr>
        <td align="center" colspan="5">Không có bệnh nhân </td>
       </tr>
       ';
        }

        }
       
        $data = array(
            'table_data'  => $output,
            'total_data'  => $total_row
        );

        echo json_encode($data);
    }
}
