<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\StaffBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentCategoriesBusinessFunction;
use App\Http\Controllers\BusinessFunction\FeedbackBusinessFunction;
use App\Model\Staff;
use App\Model\Role;
use App\Model\TreatmentCategory;
use App\Model\User;
use App\Model\Tooth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;

class StaffController extends Controller
{
    //
    use UserBusinessFunction;
    use AppointmentBussinessFunction;
    use TreatmentHistoryBusinessFunction;
    use TreatmentCategoriesBusinessFunction;
    use FeedbackBusinessFunction;
    public function loginGet(Request $request)
    {
        $sessionAdmin = $request->session()->get('currentAdmin', null);
        if ($sessionAdmin != null) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function logout(Request $request)
    {
        $request->session()->remove('currentAdmin');
        $request->session()->remove('roleAdmin');
        Auth::guard('web')->logout();
        return redirect()->route('admin.login');
    }

    public function create(Request $request)
    {

        // $checkExist = $this->checkExistUser($request->phone);
        // if ($checkExist) {
        //     return false;
        // }
        // $userHasRole = new UserHasRole();
        // $userHasRole->phone = $request->phone;
        // $userHasRole->role_id = $request->role_id;
        // $userHasRole->start_time = Carbon::now();
        // $staff = new Staff();
        // $user = new User();
        // $staff->name = $request->name;
        // $staff->address = $request->address;
        // $staff->phone = $request->phone;
        // $staff->date_of_birth = $request->date_of_birth;
        // $staff->gender = $request->gender;
        // $staff->avatar = $request->avatar;
        // $staff->district_id = $request->district_id;
        // $staff->degree = $request->degree;
        // $user->phone = $user->phone;
        // $user->password = Hash::make($user->phone);

        // $this->createUserWithRole($user, $staff, $userHasRole);
    }
    public function getStaff(Request $request){
        
        $staffs =  $this->getStaffForDataTable();
         return Datatables::of($staffs)->addColumn('action', function($staffs) {
                return '
                 <a href="#" class="show-modal btn btn-info btn-sm" data-id="'.$staffs->id.'" data-name="'.$staffs->name.'" data-address="'.$staffs->address.'"
                                           data-date="'.$staffs->date_of_birth.'" data-phone="'.$staffs->phone.'"  data-sex="'.$staffs->gender.'">
                                            <i class="fa fa-eye"></i>
                                        </a>
                <a href="#" class="edit-modal btn btn-warning btn-sm" data-id="'.$staffs->id.'" data-name="'.$staffs->name.'" data-address="'.$staffs->address.'"
                                           data-date="'.$staffs->date_of_birth.'" data-phone="'.$staffs->phone.'"  data-sex="'.$staffs->gender.'">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
               <button value="'.$staffs->id.'" class="btn btn-danger btn-sm btn-dell">  <i class="glyphicon glyphicon-trash" ></i></button>';
            })->make(true);
       
    }
    public function createStaff(Request $request){
       $post = Staff::all();
       $role = Role::all();
        return view('admin.dentist.list', ['post' => $post,'roles'=>$role]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|min:10|max:11',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('web')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
        }
        $user = $this->checkLogin($request->phone, $request->password);
        if ($user != null) {
            $roleID = $user->hasUserHasRole()->first()->belongsToRole()->first()->id;
            if ($roleID < 4 and $roleID > 0) {

                session(['currentAdmin' => $user]);
                session(['roleAdmin' => $roleID]);
                session(['currentAppointmentComming' => $this->getCurrentAppointmentComming($user->belongToStaff()->first()->id)]);
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->back()->with('fail', '* Bạn không được phép truy cập')->withInput($request->only('phone'));
        }
        return redirect()->back()->with('fail', '* Tài khoản hoặc mật khẩu sai')->withInput($request->only('phone'));
    }

    public function update(Request $request)
    {
        $idStaff = $request->staff_id;
        $this->updateStaff($request, $idStaff);

    }

    public function getListAppointmentForStaff(Request $request)
    {
        $sessionAdmin = $request->session()->get('currentAdmin', null);
        $role = $sessionAdmin->hasUserHasRole()->first()->belongsToRole()->first()->id;

        if ($role == 2) {
            $listAppointment = $this->viewAppointmentForDentist($sessionAdmin->belongToStaff()->first()->id);
        } else {
            $listAppointment = $this->viewAppointmentForReception();
        }
        foreach ($listAppointment as $appointment){
            if ($appointment->status == 0){
                $appointment->status = 'Bệnh nhân chưa đến';
            }else if ($appointment->status == 1){
                $appointment->status = 'Bệnh nhân đã đến';
            }else if ($appointment->status == 2){
                $appointment->status = 'Đang khám';
            }else if ($appointment->status == 3){
                $appointment->status = 'Đã khám';
            }else if ($appointment->status == 4){
                $appointment->status = 'Hủy';
            }
        }
        return Datatables::of($listAppointment)
            ->addColumn('action', function ($appoint) {
                return '
                <div>
                         <a href="appointment-detail/'. $appoint->id.'" class="btn btn-success">View</a>
                    <button type="button" class="btn btn-sm  btn-success" onclick="checkDone(' . $appoint->id . ')"><i class="glyphicon glyphicon-edit"></i>Hoàn Tất</button>
                </div>
                ';
            })->make(true);

    }
    public function getListAppointmentInDateForStaff(Request $request)
    {
        $sessionAdmin = $request->session()->get('currentAdmin', null);
        $role = $sessionAdmin->hasUserHasRole()->first()->belongsToRole()->first()->id;

        if ($role == 2) {
            $listAppointment = $this->viewAppointmentInDateForDentist($sessionAdmin->belongToStaff()->first()->id);
        } else {
            $listAppointment = $this->viewAppointmentInDateForReception();
        }
        foreach ($listAppointment as $appointment){
            if ($appointment->status == 0){
                $appointment->status = 'Bệnh nhân chưa đến';
            }else if ($appointment->status == 1){
                $appointment->status = 'Bệnh nhân đã đến';
            }else if ($appointment->status == 2){
                $appointment->status = 'Đang khám';
            }else if ($appointment->status == 3){
                $appointment->status = 'Đã khám';
            }else if ($appointment->status == 4){
                $appointment->status = 'Hủy';
            }
        }
        return Datatables::of($listAppointment)
            ->addColumn('action', function ($appoint) {
                return '
                <div>
                         <a href="appointment-detail/'. $appoint->id.'" class="btn btn-success">View</a>
                    <button type="button" class="btn btn-sm  btn-success" onclick="checkDone(' . $appoint->id . ')"><i class="glyphicon glyphicon-edit"></i>Hoàn Tất</button>
                </div>
                ';
            })->make(true);

    }

    public function checkComingPatient($appointmentId)
    {
        $checkComingAppointment = $this->checkAppointmentComing($appointmentId);
        $status = 0;
        if ($checkComingAppointment) {
            $status = 1;
        }
        $data = array(
            'idPatient' => $checkComingAppointment,
            'statusComing' => $status,
            'url' => request()->getHttpHost()
        );
        echo json_encode($data);

    }
    public function getList()
    {
        return $this->getListStaff();
    }

    public function createTreatmentByStaff($id)
    {
        $patient_id = $id;
        $listTreatment = $this->getAllTreatmentCategories();
        $listTooth = Tooth::all();
        return view('admin.dentist.createTreatment', ['listTreatmentCategories' => $listTreatment, 'listTooth' => $listTooth, 'patient_id' => $patient_id]);
    }

    public function viewAppointment(Request $request)
    {
        return view('admin.dentist.listAppointment');
    }

    public function viewAppointmentInDate(Request $request)
    {
        return view('admin.dentist.listAppointmentInDate');
    }

    public function receiveAppointment(Request $request)
    {
        $listTreatmentHistory = $this->checkCurrentTreatmentHistoryForPatient($request->patient_id);
        return true;
    }

    public function addPost(Request $request)
    {

        $post = new Staff;
        $post->name = $request->name;
        $post->address = $request->address;
        $post->save();
        return response()->json($post);
    }

    public function editPost(request $request)
    {
        $post = Staff::find($request->id);
        $post->name = $request->name;
        $post->address = $request->address;
        $post->save();
        return response()->json($post);
    }

    public function deletePost(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $data = array(
                'id' => $id,
            );
            $post = Staff::find($request->id)->delete();
            return response()->json($data);
        }


    }
    public function changeSession(){
        session(['currentAppointmentComming' => Session::get('currentAppointmentComming') + 1]);

        echo '';
    }
    public function profile(Request $request){
        $staff= $request->session()->get('currentAdmin');
        $staff->staffDetail = $staff->belongToStaff()->first();
        $staff->Role = $staff->hasUserHasRole()->first()->belongsToRole()->first();
        $start= $this->getNumberStart($staff->staffDetail->id); 
        
        return view('admin.Staff.profile',['staff'=>$staff,'start'=>$start]);
    } 

}
