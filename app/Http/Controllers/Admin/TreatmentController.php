<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
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
        return $this->getTreatmentHistory('1');
    }
    public function getListTreatment(Request $request){
        $listTreatment = Treatment::all();
        return Datatables::of($listTreatment)
            ->addColumn('action', function($listTreatment) {
                return '<a href="editTreatment/'.$listTreatment->id.'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Edit</a> <a id="'.$listTreatment->id.'" onclick="deleteNews(this)" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Delete</a>';
            })->make(true);
    }
    public function loadListTreatment(Request $request){
        return view('admin.treatment.list');
    }

    public function deleteTreatment(Request $request,$id){
        DB::beginTransaction();
        try{
            $Treatment = Treatment::where('id', $id)->first();
            $Treatment->delete();
            DB::commit();
            return redirect('admin/list-Treatment')->withSuccess("Liệu trình đã được xóa");
        }catch(\Exception $e){
            DB::rollback();
            return redirect('admin/list-Treatment')->withSuccess("Liệu trình được xóa");

        }
    }
    public function loadcreateMedicines(Request $request){
        $listTreatmentCategories =TreatmentCategory::all();
        return view('admin.treatment.create',['listTreatmentCategories'=>$listTreatmentCategories]);
    }
    public function createTreatment(Request $request){

        $input = $request->all();
        DB::beginTransaction();
        try{
            $Treatment = new Treatment();
            $Treatment->name =  $input['name'];
            $Treatment->treatment_category_id = $input['TreatmentCate'];
            $Treatment->description =$input['description'];
            $Treatment->max_price =(int)$input['max_price'];
            $Treatment->min_price =(int)$input['min_price'];
            $Treatment->save();

            DB::commit();
            return redirect()->route("admin.list.treatment")->withSuccess("Sự kiện đã được tạo");
        }catch(\Exception $e){
            dd($e);
            DB::rollback();
            return redirect('admin/list-Treatment')->withSuccess("Sự kiện chưa được tạo");
        }
    }
    public function loadeditTreatment($id){
        $Treatment = Treatment::find($id);
        $listTreatmentCategories =TreatmentCategory::all();
        return view("admin.treatment.edit",['Treatment'=>$Treatment,'listTreatmentCategories'=>$listTreatmentCategories]);
    }
    public function editTreatment(Request $request,$id){
        $input = $request->all();
        DB::beginTransaction();
        try{
            $Treatment = Treatment::find($id);
            $Treatment->name =  $input['name'];
            $Treatment->treatment_category_id = $input['TreatmentCate'];
            $Treatment->description =$input['description'];
            $Treatment->max_price =(int)$input['max_price'];
            $Treatment->min_price =(int)$input['min_price'];
            $Treatment->save();
            DB::commit();
            return redirect()->route("admin.list.treatment")->withSuccess("Sự kiện đã được tạo");
        }catch(\Exception $e){
            dd($e);
            DB::rollback();
            return redirect('admin/list-Treatment')->withSuccess("Sự kiện chưa được tạo");
        }

    }
}
