<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Http\Controllers\BusinessFunction\PaymentBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentCategoriesBusinessFunction;
use App\Model\TreatmentHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Treatment;
use App\Model\TreatmentCategory;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;

class TreatmentController extends Controller
{
    use TreatmentBusinessFunction;
    //
    use AppointmentBussinessFunction;
    public function getListTreatment(Request $request){
        $listTreatment = $this->getAllTreatment();
        return Datatables::of($listTreatment)
            ->addColumn('action', function($listTreatment) {
                return '<a href="editTreatment/'.$listTreatment->id.'" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Chỉnh sửa</a> <a id="'.$listTreatment->id.'" onclick="deleteNews(this)" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Xóa</a>';
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
    public function getTreatment($id){
        $treatment = $this->getTreatmentByID($id);
        return $treatment;
    }
    public function getTreatmentByCategoryId($id){
        $treat =$this->getTreatmentByCategori($id);
       return $treat;
    }
    public function testFunction(){
        dd($this->checkAppointmentForPatient('1231231231', 7));

    }
    
}
