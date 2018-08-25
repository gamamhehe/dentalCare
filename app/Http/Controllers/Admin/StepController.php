<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Model\Medicine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Step;
use App\Model\Treatment;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;

class StepController extends Controller
{
    use TreatmentHistoryBusinessFunction;
    use TreatmentBusinessFunction;
    public function create(Request $request)
    {
        $idTreatment=$request['idTreatment'];
        $list = $this->showTreatmentStepForTreatment($idTreatment);
        $countList =count($list);
        $medicineList = Medicine::all();
        return view("admin.StepTreatment.view", ['list' => $list,'count'=>$countList, 'medicineList' => $medicineList]);
//=======
       //   $listStepTreatment = $request['listStepTreatment'];
      
////        dd($request->idTreatment);
//        $list = $this->showTreatmentStepForTreatment($request->idTreatment);
//        $countList = count($list);
//        return view("admin.StepTreatment.view", ['list' => $list,'count'=>$countList,'idTreatmentHistory'=>$request->idTreatmentHistory]);
//>>>>>>> 4b8681fe961cb19a89fa36a0283f996dcaaaf368
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
    }
}
