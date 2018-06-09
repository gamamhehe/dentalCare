<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Staff;
use App\User;
use App\Treatment_category;
use Yajra\Datatables\Facades\Datatables;
class HomeController extends Controller
{
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

}
