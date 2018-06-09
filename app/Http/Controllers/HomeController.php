<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Staff;
class HomeController extends Controller
{
    public function homepage(Request $request){
    	 return view('WebUser.HomePage');
    }
    public function DoctorInformation(Request $request){
    	$doctors = DB::table('tbl_staffs')->get();
    	 

    	return view("WebUser.DoctorInformation",['doctors'=>$doctors]);
    }
}
