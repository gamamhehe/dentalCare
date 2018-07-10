<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentDetailBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use App\Http\Controllers\Controller;

class TreatmentHistoryController extends Controller
{
    //
    use TreatmentHistoryBusinessFunction;
    use TreatmentDetailBusinessFunction;
    use TreatmentBusinessFunction;
    public function createTreatmentHistory(Request $request){
        // $treatmentHistory = new TreatmentHistory();
        // $treatmentHistory->treatment_id = $request->treatment_id;
        // $treatmentHistory->patient_id = $request->patient_id;
        // $treatmentHistory->description = $request->description;
        // $treatmentHistory->create_date = Carbon::now();
        // $treatmentHistory->tooth_number = $request->tooth_number;
        // $treatmentHistory->price = $request->price;
        // $treatmentHistory->payment_id = $request->payment_id;
        // $treatmentHistory->total_price = $total_price;
         $idTreatmentHistory = $this->createTreatmentProcess($request->treatment_id,$request->patient_id,$request->tooth_number,$request->price,$request->description);
         $listStepTreatment = $this->showTreatmentStepForTreatment($request->treatment_id);
         if($idTreatmentHistory){
            return redirect()->route("admin.stepTreatment", ['idTreatmentHistory' => $idTreatmentHistory,
                'listStepTreatment' => $listStepTreatment,
              ]);

        }else{
            return redirect()->back()->withSuccess("Bài viết chưa được chỉnh");
        }
    }

    public function showTreatmentHistory(Request $request){
        $patient = $request->session()->get('currentPatient', null);
        $result =[];
        if($patient){
            $idPatient = $patient->id;
            $result = $this->getTreatmentHistory($idPatient);
        }
        return view('WebUser.TreatmentHistory', ['listTreatmentHistory'=>$result]);
    }
    public function getTreatmentHistoryByPatient($id){
        $result = $this->getTreatmentHistoryByPatientId($id);
        echo json_encode($result);
        
    }


}
