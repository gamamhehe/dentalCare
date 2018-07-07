<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\EventBusinessFunction;
use Illuminate\Http\Request;
use App\Model\TreatmentHistory;
use \Carbon\Carbon;
use App\Http\Controllers\Controller;

class TreatmentHistoryController extends Controller
{
    //
//    use EventBusinessFunction;
    use TreatmentHistoryBusinessFunction;
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

         if($this->createTreatmentProcess($request->treatment_id,$request->patient_id,$request->tooth_number,$request->price,$request->description)){
            return redirect()->route("admin.listAppointment.dentist")->withSuccess("Feedback đã được chỉnh");

        }else{
            return redirect()->back()->withSuccess("Bài viết chưa được chỉnh");
        }
    }


    public function startTreatment(Request $request){
        $idTreatment = $request->treatment_id;
        $idPatient = $request->patient_id;
        $toothNumber = $request->tooth_number;
        $price = $request->price;
        $description = $request->description;
        $listTreatmentStep = $request->listTreatmentStep;
        $note = $request->note;
        $idTreatmentHistory = $this->createTreatmentProcess($idTreatment, $idPatient, $toothNumber, $price, $description);
        //id đó là id của TreatmentHistory vừa tạo =>Pass wa treatment Detail ( là step);
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
