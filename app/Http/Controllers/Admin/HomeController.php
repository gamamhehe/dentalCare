<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\StaffBusinessFunction;
use App\Http\Controllers\BusinessFunction\NewsBussinessFunction;
use App\Model\User;
use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Http\Controllers\BusinessFunction\EventBusinessFunction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Staff;
use App\TreatmentCategory;
use Config;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;
class HomeController extends Controller
{

    use TreatmentBusinessFunction;
    use UserBusinessFunction;
    use StaffBusinessFunction;
    use NewsBussinessFunction;

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
    	 $ahi = $doctors = DB::table('tbl_treatment_categories')->get();
    	 return Datatables::of($ahi)->make(true);

    }
    public function createNews(Request $request){
        echo "string";
        exit();
    }
    public function Profile(Request $request){
        return view('WebUser.User.Profile');
    }
    public function getNewsWebUser($id){

       $News = $this->getNews($id);
        
       if($News){
           return view("WebUser.News.News",['News'=>$News]);
       }else{
         return view($this->errorBag());
       }

    }
    public function eventLoad(Request $request){
        $listNews = $this->getListNewsOfEvent();
        $NewEventNews = $this->getNewestNews();
       return view('WebUser.Events',['listNews'=>$listNews,'NewEventNews'=>$NewEventNews]);
    }
    public function eventLoadByID(Request $request,$id){
        $listNews = $this->getListNewsOfEvent();
        $NewEventNews = $this->getNews($id);

        return view('WebUser.Events',['listNews'=>$listNews,'NewEventNews'=>$NewEventNews]);
    }

    public function myProfile($id){
        return view("WebUser.User.MyProfile");
    }
    public function aboutUs(Request $request){
        return view("WebUser.User.AboutUs");
    }



    public function testFunction(){
        User::All();
        $this->getCurrentNumberDentist();
    }

    public function registerPost(Request $request){
        $this->validate($request, [
            'phone' => 'required|min:10|max:11',
            'password' => 'required|min:6',
            'address' => 'required',
            'date_of_birth' => 'required',
            'district_id' => 'required'
        ]);
    }
    public function logout(Request $request){
        $request->session()->remove('currentUser');
        $request->session()->remove('listPatient');
        return redirect()->route('homepage');
    }
}
