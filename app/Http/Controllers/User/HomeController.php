<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Staff;
use App\TreatmentCategory;
use Config;
use Yajra\Datatables\Facades\Datatables;
class HomeController extends Controller
{

    use UserBusinessFunction;

    public function homepage(Request $request){
    	 return view('WebUser.HomePage');
    }
    public function DoctorInformation(Request $request){
    	$doctors = DB::table('tbl_staffs')->get();
    	 

    	return view("WebUser.DoctorInformation",['doctors'=>$doctors]);
    }
     public function BangGiaDichVu(){
    	return view('WebUser.ServicePrice');
    }
    public function getDB(){
    	 $ahi = 	$doctors = DB::table('tbl_treatment_categories')->get();
    	 return Datatables::of($ahi)->make(true);

    }
    public function createNews(Request $request){
        echo "string";
        exit();
    }
    public function Profile(Request $request){
        return view('WebUser.User.Profile');
    }

    public function login(Request $request){
        $this->validate($request, [
            'phone' => 'required|min:10|max:11',
            'password' => 'required|min:6'
        ]);
        $user = $this->checkLogin($request->phone, $request->password);
        if ($user != null) {
            $roleID = $user->hasUserHasRole()->first()->belongsToRole()->first()->id;
            if ($roleID == 2) {
                session(['currentUser' => $user]);
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->back()->with('fail', '* You do not have permission for this page')->withInput($request->only('phone'));
        }
        return redirect()->back()->with('fail', '* Wrong phone number or password')->withInput($request->only('phone'));
    }
}
