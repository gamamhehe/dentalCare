<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Medicine;
use DB;
use Yajra\Datatables\Facades\Datatables;

class MedicineController extends Controller
{
    public function createMedicines(Request $request){
        $input = $request->all();
        DB::beginTransaction();
        try{
            $Medicines = new Medicine();
            $Medicines->name =  $input['name'];
            $Medicines->use = $input['use'];
            $Medicines->description =$input['description'];
            $Medicines->save();
            DB::commit();
            return redirect()->route("admin.list.medicines")->withSuccess("Sự kiện đã được tạo");
        }catch(\Exception $e){
            dd($e);
            DB::rollback();
            return redirect('admin/list-Medicines')->withSuccess("Sự kiện chưa được tạo");
        }
    }

    public function getListMedicines(Request $request){
        $listEvent = Medicine::all();
        return Datatables::of($listEvent)
            ->addColumn('action', function($listEvent) {
                return '<a href="editMedicines/'.$listEvent->id.'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Edit</a> <a id="'.$listEvent->id.'" onclick="deleteNews(this)" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Delete</a>';
            })->make(true);
    }
    public function loadcreateMedicines(Request $request){
        return view('admin.medicines.create');
    }
    public function loadListMedicines(Request $request){
        return view('admin.medicines.list');
    }
    public function loadeditMedicines($id){
      $Medicines = Medicine::find($id);

        return view("admin.medicines.edit",['Medicines'=>$Medicines]);
    }
    public function editMedicines(Request $request,$id){

        $input = $request->all();
        DB::beginTransaction();
        try{
            $Medicines = Medicine::find($id);
            $Medicines->name = $input['name'];
            $Medicines->use = $input['use'];
            $Medicines->description = $input['description'];
            $Medicines->save();
            DB::commit();
            return redirect()->route("admin.list.medicines")->withSuccess("Thuốc đã được chỉnh");

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->withSuccess("Thuốc chưa được chỉnh");

        }

    }
    public function deletMedicines(Request $request,$id){
        DB::beginTransaction();
        try{
            $Medicine = Medicine::where('id', $id)->first();
            $Medicine->delete();
            DB::commit();
            return redirect('admin/list-Medicines')->withSuccess("Thuốc đã được xóa");
        }catch(\Exception $e){
            DB::rollback();
            return redirect('admin/list-Medicines')->withSuccess("Thuốc chưa được xóa");

        }
    }
}
