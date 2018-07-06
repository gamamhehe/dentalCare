<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\StaffBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Model\Staff;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
class StaffController extends Controller
{
    //
    use UserBusinessFunction;
    use AppointmentBussinessFunction;
    use TreatmentHistoryBusinessFunction;
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
        $request->session()->remove('role');
        return redirect()->route('admin.login');
    }

    public function create(Request $request)
    {
        $post = Staff::all();
        return view('admin.dentist.list',['post'=>$post]);
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

    public function login(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|min:10|max:11',
            'password' => 'required|min:6'
        ]);
        $user = $this->checkLogin($request->phone, $request->password);
        if ($user != null) {
            $roleID = $user->hasUserHasRole()->first()->belongsToRole()->first()->id;
            if ($roleID < 4 and $roleID > 0) {
                session(['currentAdmin' => $user]);
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->back()->with('fail', '* You do not have permission for this page')->withInput($request->only('phone'));
        }
        return redirect()->back()->with('fail', '* Wrong phone number or password')->withInput($request->only('phone'));
    }

    public function update(Request $request)
    {
        $idStaff = $request->staff_id;
        $this->updateStaff($request, $idStaff);

    }
    public function getListAppointmentByDentist(Request $request){
        $sessionAdmin = $request->session()->get('currentAdmin', null);
        $list = $this->getAppointmentByPhone( $sessionAdmin->phone);

        return Datatables::of($list)
            ->addColumn('action', function($appoint) {
                return '<a href="editNews/'.$appoint->id.'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>CC gì</a> <a id="'.$appoint->id.'" onclick="deleteNews(this)" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Ai biet</a>';
            })->make(true);
        
    }
    public function getList()
    {
        return $this->getListStaff();
    }

    public function viewAppointment(Request $request)
    {
        // $sessionAdmin = $request->session()->get('currentAdmin', null);
        // $role = $sessionAdmin->hasUserHasRole()->first()->belongsToRole()->first()->id;
        // if ($role == 2) {
        //     $listAppointment = $this->viewAppointmentForDentist($sessionAdmin->belongToStaff()->first()->id);
        // } else {
        //     $listAppointment = $this->viewAppointmentForReception();
        // }

        return view('admin.dentist.listAppointment');
    }

    public function receiveAppointment(Request $request){
        $listTreatmentHistory = $this->checkCurrentTreatmentHistoryForPatient($request->patient_id);
        return true;
    }

    public function addPost(Request $request){

        $post = new Staff;
        $post->name = $request->name;
        $post->address = $request->address;
        $post->save();
        return response()->json($post);
    }

    public function editPost(request $request){
        $post = Staff::find ($request->id);
        $post->name = $request->name;
        $post->address = $request->address;
        $post->save();
        return response()->json($post);
    }
    public function deletePost(Request $request){
        $id = $request->id;
        if($id){
             $data = array(
            'id'  => $id,
            );
        $post = Staff::find ($request->id)->delete();
        return response()->json($data);
        }        


       
    }

}
