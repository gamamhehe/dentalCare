<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function homepage(Request $request){
    	 return view('WebUser.HomePage');
    }
    public function DoctorInformation(Request $request){
    	return view("WebUser.DoctorInformation");
    }
}
