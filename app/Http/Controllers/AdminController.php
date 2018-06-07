<?php

namespace App\Http\Controllers;

use App\Model\Role;
use App\Model\User;
use App\Model\User_has_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Auth;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admins', ['except' => ['logout']]);
    }

    //
    public function checkSessionLogin(Request $request)
    {
        $sessionUser = $request->session()->get('idAdmin', 'default');
        if ($sessionUser == 'default') {
            return view('admin.login');
        } else {
            return view('admin.dashboard');
        }
    }

    public function checkLogin(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|min:10|max:11',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('admins')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
            // if successful, then redirect to their intended location
//            dd(Auth::guard('admins')->user()->has_role()->first()->Role()->first()->name);
            session(['admin' => Auth::guard('admins')->user()]);
            if (Auth::guard('admins')->user()->hasRole()->first()->getRole()->first()->id != 1) {
                return redirect()->back()->with('fail', '* You do not have permission for this page')->withInput($request->only('phone'));
            }
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->back()->with('fail', '* Wrong phone number or password')->withInput($request->only('phone'));
    }

    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->remove('admin');
        return redirect()->route('checkSessionLogin');
    }

    public function initAdmin()
    {
        User::create([
            'phone' => '01279011096',
            'password' => Hash::make('#2017#'),
            'isActive' => true,
            'isDelete' => false
        ]);
        User_has_role::create([
            'phone' => '01279011096',
            'role_id' => 1,
            'role_start_time' => Carbon::now(),
            'role_end_time' => null
        ]);
        Role::create([
            'id' => '1',
            'name' => 'Administrator',
            'description' => 'Administrator of all system',
        ]);

    }

    public function initAdmin2()
    {
        User::create([
            'phone' => '01279011097',
            'password' => Hash::make('#2017#'),
            'isActive' => true,
            'isDelete' => false
        ]);
        User_has_role::create([
            'phone' => '01279011097',
            'role_id' => 2,
            'role_start_time' => Carbon::now(),
            'role_end_time' => null
        ]);
        Role::create([
            'id' => '2',
            'name' => 'Doctor',
            'description' => 'Doctor of dental Clinic',
        ]);

    }
    // tao ghim lắm nha ! TAO LÀM. DATA Là TAOOO LÀM NHA TÀi !
    public function initTreatmentCategories()
    {
        User::create([
            'phone' => '01279011097',
            'password' => Hash::make('#2017#'),
            'isActive' => true,
            'isDelete' => false
        ]);
         

    }
}
