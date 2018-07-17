<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AnamnesisBusinessFunction;
use App\Http\Controllers\BusinessFunction\NewsBussinessFunction;
use App\Model\AnamnesisCatalog;
use App\Model\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\Datatables\Facades\Datatables;
use DB;
class AnamnesisController extends Controller
{
    use NewsBussinessFunction;
    use AnamnesisBusinessFunction;

    public function create(Request $request){
        if($this->createAnamnesis($request->all())){
            return redirect()->route("admin.list.anamnesis")->withSuccess("Loại bệnh đã được tạo");
        }else{
            return redirect('admin/Anamnesis/list')->withSuccess("Loại bệnh chưa được tạo");
        }


    }
    public function getList(Request $request){
        $AnamnesisCatalog = $this->getAllAnamnesis();

        return Datatables::of($AnamnesisCatalog)
            ->addColumn('action', function($AnamnesisCatalog) {
                return '<a href="editAnamnesis/'.$AnamnesisCatalog->id.'" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Chỉnh sửa</a> <a id="'.$AnamnesisCatalog->id.'" onclick="deleteAnamnesis(this)" class="btn btn-success btn-sm "><i class="glyphicon glyphicon-edit"></i>Xóa</a>';
            })->make(true);

    }
    public function loadcreate(Request $request){
        return view('admin.anamnesis.create');
    }
    public function loadList(Request $request){
//
        return view('admin.anamnesis.list');
    }
    public function loadEdit($id){
        $AnamnesisCatalog = AnamnesisCatalog::find($id);
        $content = $AnamnesisCatalog->image_header;
        return view("admin.anamnesis.edit",['AnamnesisCatalog'=>$AnamnesisCatalog,'xxx'=>$content]);
    }
    public function edit(Request $request,$id){

        if($this->editAnamnesis($request->all(),$id)){
            return redirect()->route("admin.list.anamnesis")->withSuccess("Loại bệnh đã được tạo");
        }else{
            return redirect('admin/Anamnesis/list')->withSuccess("Loại bệnh chưa được tạo");
        }



    }
    public function delete($id){
        if( $this->deletAnamnesis($id)){
            return redirect('admin/list-Anamnesis')->withSuccess("Loại bệnh đã được xóa");
        }else{
            return redirect('admin/list-Anamnesis')->withSuccess("Loại bệnh chưa được xóa");
        }
        DB::beginTransaction();
        try{
            $AnamnesisCurrent = AnamnesisCatalog::where('id', $id)->first();
            $AnamnesisCurrent->delete();
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollback();
            return false;

        }



    }
}
