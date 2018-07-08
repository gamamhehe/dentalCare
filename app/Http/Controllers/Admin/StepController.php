<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Step;
use App\Model\Treatment;

class StepController extends Controller
{
    public function create(Request $request)
    {
        $treatmentCate = 1;
        $list = Treatment::where('treatment_category_id', 1)->get();
        return view("admin.StepTreatment.view", ['list' => $list]);
    }

    public function add(Request $request)
    {
        dd($request->all());
    }
}
