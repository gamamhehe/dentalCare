<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\StaffBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentCategoriesBusinessFunction;
use App\Http\Controllers\BusinessFunction\FeedbackBusinessFunction;
use Illuminate\Support\Facades\Hash;
use App\Model\Staff;
use App\Model\UserHasRole;
use App\Model\Role;
use App\Model\City;
use App\Model\District;
use App\Model\TreatmentCategory;
use App\Model\User;
use App\Model\Tooth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
            return redirect()->route('admin.AppointmentPatient.index');
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

        $checkExist = $this->checkExistUser($request->phone);
        if ($checkExist) {
            return false;
        }
        $userHasRole = new UserHasRole();
        $userHasRole->phone = $request->phone;
        $userHasRole->role_id = $request->role_id;
        $userHasRole->start_time = Carbon::now();
        $staff = new Staff();
        $user = new User();
        $staff->name = $request->name;
        $staff->address = $request->address;
        $staff->phone = $request->phone;
        $staff->date_of_birth = $request->date_of_birth;
        $staff->gender = $request->gender;
        $staff->avatar = $request->avatar;
        $staff->district_id = $request->district_id;
        $staff->degree = $request->degree;
        $user->phone = $user->phone;
        $user->password = Hash::make($user->phone);

        $this->createUserWithRole($user, $staff, $userHasRole);
    }

    public function createStaff(Request $request)
    {
        $checkExist = $this->checkExistUser($request->phone);
        if ($checkExist) {
            return 0;
        }
        $district = District::where('id', $request->district_id)->first();
        $districtName = $district->name;
        $cityName = $district->belongsToCity()->first()->name;
        $address = $request->address . ", " . $districtName . ", " . $cityName;

        $userHasRole = new UserHasRole();
        $userHasRole->phone = $request->phone;
        $userHasRole->role_id = $request->role_id;
        $userHasRole->start_time = Carbon::now();

        $staff = new Staff();
        $staff->name = $request->name;
        $staff->address = $address;
        $totalAddress = $request->address . ", " . $request->district_id . ", " . $request->city;
        $staff->phone = $request->phone;
        $staff->date_of_birth = (new Carbon($request->date_of_birth))->format('Y-m-d H:i:s');
        $staff->gender = $request->gender;
        $staff->avatar = "/assets/images/avatar/default_avatar.jpg";
        $staff->district_id = $request->district_id;
        $staff->email = $request->email;
        $staff->degree = $request->degree;
        $staff->description = $request->description;
        $user = new User();
        $user->phone = $request->phone;
        $user->password = Hash::make($user->phone);
        $result = $this->createStaffWithRole($user, $staff, $userHasRole);

        if ($result == false) {
            return 1;
        } else {
            return 2;
        }

    }

    public function getStaff(Request $request)
    {
        $staffs = $this->getStaffForDataTable();
        return Datatables::of($staffs)->addColumn('action', function ($staffs) {
            return '
                 <a href="#" class="show-modal btn btn-info btn-sm" data-id="' . $staffs->id . '" data-name="' . $staffs->name . '" data-address="' . $staffs->address . '"
                                           data-date="' . $staffs->date_of_birth . '" data-phone="' . $staffs->phone . '"  data-sex="' . $staffs->gender . '" data-role="' . $staffs->RoleStaff . '">
                                            <i class="fa fa-eye"></i>
                                        </a>
                <a href="#" class="edit-modal btn btn-warning btn-sm" data-id="' . $staffs->id . '" data-name="' . $staffs->name . '" data-address="' . $staffs->address . '"
                                           data-date="' . $staffs->date_of_birth . '" data-phone="' . $staffs->phone . '"  data-sex="' . $staffs->gender . '" data-role="' . $staffs->staffRoleID . '">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                ';
        })->make(true);

    }
    public function editStaff(Request $request){
      
        DB::beginTransaction();
        try {
            $staff = Staff::find($request->id);
            $staff->name = $request->name;
            $staff->address = $request->address;
            $staff->gender = $request->gender;
            $userHasRole = UserHasRole::where('phone', $staff->phone)->get();
            if ($userHasRole[0]->role_id != $request->role_id) {
                $userHasRole[0]->end_time = Carbon::now();
                // $userHasRole = new UserHasRole();
                $userHasRole[0]->role_id = $request->role_id;
                $userHasRole[0]->start_time = Carbon::now();
                
            }
            $userHasRole[0]->save();
            $staff->save();
            DB::commit();
            return 0;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return 1;
        }
    }
    public function listStaff(Request $request)
    {
        $post = Staff::all();
        $city = City::all();
        $role = Role::all();
        $district = District::all();
        return view('admin.dentist.list', ['post' => $post, 'roles' => $role, 'citys' => $city, 'District' => $district]);
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
                return redirect()->intended(route('admin.AppointmentPatient.index'));
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
        foreach ($listAppointment as $appointment) {
               $appointment->statusButton="1";
             if ($appointment->status == 0) {
                $appointment->status = 'Bệnh nhân chưa đến';
            } else if ($appointment->status == 1) {
                $appointment->status = "Bệnh nhân đã đến";
            } else if ($appointment->status == 2) {
                $appointment->status = 'Đang khám';
            } else if ($appointment->status == 3) {
                $appointment->status = 'Đã khám';
               
            } else if ($appointment->status == 4) {
                $appointment->status = 'Hủy';
            }
            $appointment->dentist = $appointment->belongsToStaff()->first()->name;
        }
        return Datatables::of($listAppointment)
            ->addColumn('action', function ($appoint) {
            if(Session::get('roleAdmin') == 2 or Session::get('roleAdmin') == 1){
                            if ($appoint->status == 'Bệnh nhân đã đến') {
                                return '<div>
                                <a href="appointment-detail/' . $appoint->id . '" class="btn btn-sm btn-success">Chi tiết</a>
                                <button type="button" class="btn btn-sm  btn-success" onclick="checkStart(' . $appoint->id . ')">Bắt đầu</button>
                            </div>';
                            } else if ($appoint->status == 'Đang khám') {
                                    return '<div>
                                <a href="appointment-detail/' . $appoint->id . '" class="btn btn-sm btn-success">Chi tiết</a>
                                <button type="button" class="btn btn-sm  btn-success"onclick="checkDone(' . $appoint->id . ')">Hoàn tất</button></div>
                                ';
                                } else {
                                    return '
                            <div>
                                <a href="appointment-detail/' . $appoint->id . '" class="btn btn-sm btn-success">Chi tiết</a>
                            </div>
                            ';
                                }
            }else{
                 return '<div><a href="appointment-detail/' . $appoint->id . '" class="btn btn-sm btn-success">Chi tiết</a></div>';
            }
            })->addColumn('buttonStatus',function ($appointment) {
                if ($appointment->status == 'Bệnh nhân chưa đến') {
               return "<h4><span class=\"label label-primary\" style=\"display: block; 
    min-height: 100%;\">Bệnh nhân chưa đến</span></h4>";
            } else if ($appointment->status == 'Bệnh nhân đã đến') {
                 return "<h4><span class=\"label label-success\" style=\"display: block; 
    min-height: 100%;\">Bệnh nhân đã đến</span></h4>";
            } else if ($appointment->status == 'Đang khám') {
                 return "<h4><span class=\"label label-success\" style=\"display: block; 
    min-height: 100%;\">Đang khám</span></h4>";
            } else if ($appointment->status =='Đã khám') {
                 return "<h4><span class=\"label label-warning\" style=\"display: block; 
    min-height: 100%;\">Đã khám</span></h4>";
            } else if ($appointment->status =='Hủy') {
               return "<h4><span class=\"label label-default\" style=\"display: block; 
    min-height: 100%;\">Hủy</span></h4>";
            }
            }) ->rawColumns(['buttonStatus', 'action'])->make(true);

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
        foreach ($listAppointment as $appointment) {
            $appointment->statusButton="";
            if ($appointment->status == 0) {
                $appointment->status = 'Bệnh nhân chưa đến';
            } else if ($appointment->status == 1) {
                $appointment->status = 'Bệnh nhân đã đến';
            } else if ($appointment->status == 2) {
                $appointment->status = 'Đang khám';
            } else if ($appointment->status == 3) {
                $appointment->status = 'Đã khám';
            } else if ($appointment->status == 4) {
                $appointment->status = 'Hủy';
               
            }
            $appointment->time = date("H:i:s", strtotime($appointment->start_time));
            $appointment->dentist = $appointment->belongsToStaff()->first()->name;
        }
        return Datatables::of($listAppointment)
            ->addColumn('action', function ($appoint) {
            if(Session::get('roleAdmin') == 2 or Session::get('roleAdmin') == 1){
                            if ($appoint->status == 'Bệnh nhân đã đến') {
                                return '<div>
                                <a href="appointment-detail/' . $appoint->id . '" class="btn btn-sm btn-success">Chi tiết</a>
                                <button type="button" class="btn btn-sm  btn-success" onclick="checkStart(' . $appoint->id . ')">Bắt đầu</button>
                            </div>';
                            } else if ($appoint->status == 'Đang khám') {
                                    return '<div>
                                <a href="appointment-detail/' . $appoint->id . '" class="btn btn-sm btn-success">Chi tiết</a>
                                <button type="button" class="btn btn-sm  btn-success"onclick="checkDone(' . $appoint->id . ')">Hoàn tất</button></div>
                                ';
                                } else {
                                    return '
                            <div>
                                <a href="appointment-detail/' . $appoint->id . '" class="btn btn-sm btn-success">Chi tiết</a>
                            </div>
                            ';
                                }
            }else{
                 return '<div><a href="appointment-detail/' . $appoint->id . '" class="btn btn-sm btn-success">Chi tiết</a></div>';
            }
            })->addColumn('buttonStatus',function ($appointment) {
                if ($appointment->status == 'Bệnh nhân chưa đến') {
               return "<h4><span class=\"label label-primary\" style=\"display: block; 
    min-height: 100%;\">Bệnh nhân chưa đến</span></h4>";
            } else if ($appointment->status == 'Bệnh nhân đã đến') {
                 return "<h4><span class=\"label label-success\" style=\"display: block; 
    min-height: 100%;\">Bệnh nhân đã đến</span></h4>";
            } else if ($appointment->status == 'Đang khám') {
                 return "<h4><span class=\"label label-success\" style=\"display: block; 
    min-height: 100%;\">Đang khám</span></h4>";
            } else if ($appointment->status =='Đã khám') {
                 return "<h4><span class=\"label label-warning\" style=\"display: block; 
    min-height: 100%;\">Đã khám</span></h4>";
            } else if ($appointment->status =='Hủy') {
               return "<h4><span class=\"label label-default\" style=\"display: block; 
    min-height: 100%;\">Hủy</span></h4>";
            }
            }) ->rawColumns(['buttonStatus', 'action'])->make(true);

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

    public function changeSession()
    {
        $user = Session::get('currentAdmin');
        session(['currentAppointmentComming' => $this->getCurrentAppointmentComming($user->belongToStaff()->first()->id)]);
        echo '';
    }

    public function profile(Request $request)
    {
        $staff = $request->session()->get('currentAdmin');
        $staff->staffDetail = $staff->belongToStaff()->first();
        $staff->Role = $staff->hasUserHasRole()->first()->belongsToRole()->first();
        $start = $this->getNumberStart($staff->staffDetail->id);

        return view('admin.Staff.profile', ['staff' => $staff, 'start' => $start]);
    }
    public function getAllStaffAjax(Request $request){

    }
    public function getFreeDentistInStaff(Request $request)
    {
        $list = $this->getCurrentFreeDentist();
        $listObj = [];
        foreach ($list as $dentist => $key) {
            $x = Staff::find($key);
            $listObj[] = $x;
        }
        $list2 = UserHasRole::where('role_id', '2')->get();
        $dentist = [];
        foreach ($list2 as $key) {
            $dentist[] = $key->belongsToUser()->first()->belongToStaff()->first();
        }
        foreach ($dentist as $key) {
            for ($i = 0; $i < count($listObj); $i++) {
                if ($key->id == $listObj[$i]->id) {
                    $key->statusCurrent = "Đang rảnh";
                    $key->booleanStatus = 'color:white;background-color:#5cb85c';
                    $key->style = "StyleStatus" . $key->id;
                    break;
                } else {
                    $key->statusCurrent = "Đang bận";
                    $key->booleanStatus = 'color:white;background-color:red';
                }
            }
        }

        $output = '';
        $total_row = count($dentist);
        if ($total_row > 0) {
            foreach ($dentist as $row) {
                $output .= '
        <tr>
        <th  style="text-align: center; " class="col-xs-4 ">' . $row->name . '</th>
        <th   style="text-align: center; ' . $row->booleanStatus . '" class="col-xs-1">' . $row->statusCurrent . '</th>
        <th   style="text-align: center; " class="col-xs-1  "> <button class="btn btn-info" type="button" style=" width: 100%;" id="add" onclick="savePatient(' . $row->id . ')" >Chọn bác si</button></th>
        </tr>
        ';
            }

        }
        if ($total_row == 0) {
            $output = '
       <tr>
        <td align="center" colspan="5">Tất cả bác sĩ đều bận </td>
       </tr>
       ';
        }
        $data = array(
            'table_data' => $output,
            'total_data' => $total_row
        );
        echo json_encode($data);

    }

    public function createAppointmentByStaff(Request $request)
    {
        $RoleDentist = UserHasRole::where('role_id', '2')->get();
        $dentist = [];
        foreach ($RoleDentist as $key) {
            $dentist[] = $key->belongsToUser()->first()->belongToStaff()->first();
        }
        return view("admin.AppointmentPatient.createAppointmentManual", ['dentists' => $dentist]);
    }

}
