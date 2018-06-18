<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BusinessFunction\NewsBussinessFunction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Staff;
use App\TreatmentCategory;
use Config;
use Yajra\Datatables\Facades\Datatables;
class HomeController extends Controller
{
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
    public function getNewsWebUser($id){

       $News = $this->getNews($id);
       if($News){
           return view("WebUser.News.News",['News'=>$News]);
       }else{
         return view($this->errorBag());
       }

    }
    public function eventLoad(Request $request){
       return view('WebUser.Events');
    }
    public function myProfile($id){
        return view("WebUser.User.MyProfile");
    }
    public function aboutUs(Request $request){
        return view("WebUser.User.aboutUs");
    }

}
