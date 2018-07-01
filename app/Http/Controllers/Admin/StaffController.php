<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\StaffBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Model\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    //
    use UserBusinessFunction;
    use StaffBusinessFunction;

    public function loginGet(Request $request)
    {
        $sessionUser = $request->session()->get('role', -1);
        if ($sessionUser != -1) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function logout(Request $request)
    {
        $request->session()->remove('role');
        return redirect()->route('admin.login');
    }

    public function create(Request $request){
        $checkExist = $this->checkExistUser($request->phone);
        if($checkExist){
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
        $this->createStaff($staff, $userHasRole);
        $this->createUser($user);
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

    public function update(Request $request){
        $idStaff = $request->staff_id;
        $this->updateStaff($request, $idStaff);

    }

    public function getList(){
        return $this->getListStaff();
    }
}
