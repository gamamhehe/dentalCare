<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Model\TreatmentHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TreatmentController extends Controller
{
    use TreatmentBusinessFunction;
    //
    public function showTreatmentHistory(Request $request){
        $patient = $request->session()->get('currentPatient', null);
        if($patient){
            $idPatient = $patient->id;
            $result = $this->getTreatmentHistory($idPatient);
        }
        return view('WebUser.TreatmentHistory', ['listTreatmentHistory'=>$result]);
    }

    public function createTreatmentHistory(Request $request){
        $treatmentHistory = new TreatmentHistory();
        $treatmentHistory->treatment_id = $request->treatment_id;
        $treatmentHistory->patient_id = $request->patient_id;
        $treatmentHistory->descripttion = $request->descripttion;
        $treatmentHistory->create_date = Carbon::now();
        $treatmentHistory->tooth_number = $request->tooth_number;
        $treatmentHistory->price = $request->price;
        $treatmentHistory->payment_id = $request->payment_id;
        $treatmentHistory->total_price = $request->total_price;
        $this->saveTreatmentHistory($treatmentHistory);
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
        $this->creatTreatmentDetail($listTreatmentStep, $idTreatmentHistory, $note);
    }
}
