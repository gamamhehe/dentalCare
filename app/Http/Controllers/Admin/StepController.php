<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Step;
use App\Model\Treatment;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;

class StepController extends Controller
{
    use TreatmentHistoryBusinessFunction;
    public function create(Request $request)
    {
        $listStepTreatment =$request['listStepTreatment'];
        // $listStepTreatmentDone =$request['listStepTreatmentDone'];
        $list = Treatment::where('treatment_category_id', 1)->get();
        $countList =count($list);

        return view("admin.StepTreatment.view", ['list' => $list,'count'=>$countList,'listStepTreatment'=>$listStepTreatment]);
    }
    public function edit(Request $request)
    {
        $listStepTreatment =$request['listStepTreatment'];
        $listStepTreatmentDone =$request['listStepTreatmentDone'];
        $list = Treatment::where('treatment_category_id', 1)->get();
        $countList =count($list);
        return view("admin.StepTreatment.view", ['list' => $list,'count'=>$countList,'listStepTreatment'=>$listStepTreatment,'listStepTreatmentDone'=>$listStepTreatmentDone]);
    }

    public function add(Request $request)
    {
        dd($request->all());
    }
}
