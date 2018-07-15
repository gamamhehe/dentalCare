<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
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
    use AppointmentBussinessFunction;
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
         if($idTreatmentHistory){
            return redirect()->route("admin.stepTreatment", ['idTreatmentHistory' => $idTreatmentHistory,
                'idTreatment' => $request->treatment_id,
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
        $checkComingAppointment = $this->checkAppointmentComing($id);
        $data = array(
            'statusComing' => 0,
        );
        if ($checkComingAppointment) {
            $result = $this->getTreatmentHistoryByPatientId($checkComingAppointment);
            foreach ($result as $key ) {
                $key->nameTreat = $key->belongsToTreatment()->first();
            }
            $data = array(
                'statusComing' => 1,
                'resultHis' => $result
            );
        }
        echo json_encode($data);
    }

    public function getList(){
        $treatmentHistoryList = $this->getListTreatmentHistory();
        return view('admin.treatmentHistory.list',['treatmentHistoryList' => $treatmentHistoryList]);
    }

    public function getDetail(Request $request){
        $treatmentHistory = $this->getTreatmentHistoryDetail($request->idTreatmentHistory);
        return view('admin.treatmentHistory.detail', ['treatmentHistory' => $treatmentHistory]);
    }

}
