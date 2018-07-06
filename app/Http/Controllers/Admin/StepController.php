<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StepController extends Controller
{
    public function create(Request $request){
    	return view("admin.StepTreatment.view");
    }
}
