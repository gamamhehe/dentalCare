<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Http\Controllers\BusinessFunction\PaymentBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentCategoriesBusinessFunction;
use App\Model\TreatmentHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Treatment;
use App\Model\TreatmentCategory;
use DB;
use Yajra\Datatables\Facades\Datatables;
class TreatmentController extends Controller
{
    use TreatmentBusinessFunction;
    //
    public function showTreatmentHistory(Request $request){
        $patient = $request->session()->get('currentPatient', null);
        $result =[];
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
    public function getListTreatment(Request $request){
        $listTreatment = $this->getAllTreatment();
        return Datatables::of($listTreatment)
            ->addColumn('action', function($listTreatment) {
                return '<a href="editTreatment/'.$listTreatment->id.'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Edit</a> <a id="'.$listTreatment->id.'" onclick="deleteNews(this)" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Delete</a>';
            })->make(true);
    }
    public function loadListTreatment(Request $request){
        return view('admin.treatment.list');
    }
    public function delete($id){

        if($this->deleteTreatment($id)){
            return redirect('admin/list-Treatment')->withSuccess("Liệu trình đã được xóa");

        }else{
            return redirect('admin/list-Treatment')->withSuccess("Liệu trình được xóa");

        }
    }
    public function loadcreate(Request $request){

        $listTreatmentCategories =TreatmentCategory::all();
        return view('admin.treatment.create',['listTreatmentCategories'=>$listTreatmentCategories]);
    }
    public function create(Request $request){
        if($this->createTreatment($request->all())){
            return redirect()->route("admin.list.treatment")->withSuccess("Sự kiện đã được tạo");
        }else{
            return redirect('admin/list-Treatment')->withSuccess("Sự kiện chưa được tạo");
        }
    }
    public function loadeditTreatment($id){
        $Treatment = $this->getTreatmentByID($id);
        $listTreatmentCategories =TreatmentCategory::all();
        return view("admin.treatment.edit",['Treatment'=>$Treatment,'listTreatmentCategories'=>$listTreatmentCategories]);
    }
    public function edit(Request $request,$id){
        if($this->editTreatment($request->all(),$id)){
            return redirect()->route("admin.list.treatment")->withSuccess("Sự kiện đã được tạo");

        }else{
            return redirect('admin/list-Treatment')->withSuccess("Sự kiện chưa được tạo");

        }
    }

    public function createMedicineForTreatmentDetail($idTreatmentDetail, $quantity, $medicine_id){

    }
}
