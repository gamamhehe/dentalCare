<?php

namespace App\Http\Controllers\Admin;

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
    public function create(Request $request){

        $input = $request->all();

        $AnamnesisCatalog = new AnamnesisCatalog;
        $AnamnesisCatalog->name = $input['name'];
        $AnamnesisCatalog->description =  $input['description'];
        $AnamnesisCatalog->save();

        if($AnamnesisCatalog){
            return redirect()->route("admin.list.anamnesis")->withSuccess("Bài viết đã được tạo");
        }else{
            return redirect('admin/Anamnesis/list')->withSuccess("Bài viết chưa được tạo");
        }


    }

    public function getList(Request $request){
        $AnamnesisCatalog = AnamnesisCatalog::all();

        return Datatables::of($AnamnesisCatalog)
            ->addColumn('action', function($AnamnesisCatalog) {
                return '<a href="editAnamnesis/'.$AnamnesisCatalog->id.'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Edit</a> <a id="'.$AnamnesisCatalog->id.'" onclick="deleteAnamnesis(this)" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Delete</a>';
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
    public function editdAnamnesis(Request $request,$id){

        $input = $request->all();

        DB::beginTransaction();
        try{

            $AnamnesisCatalog = AnamnesisCatalog::where('id', $id)->first();
            $AnamnesisCatalog->name = $input['name'];
            $AnamnesisCatalog->description =  $input['description'];
            $AnamnesisCatalog->save();
            DB::commit();
            return redirect('admin/list-Anamnesis')->withSuccess("Loại bệnh đã được chỉnh sửa");

        }catch(\Exception $e){
            DB::rollback();
            return redirect('admin/list-Anamnesis')->withSuccess("Loại bệnh chưa được chỉnh sửa");
        }


    }
    public function deleteAnamnesis(Request $request,$id){

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
        if($Newsxxx){
            return redirect('admin/list-Anamnesis')->withSuccess("Loại bệnh đã được xóa");
        }else{
            return redirect('admin/list-Anamnesis')->withSuccess("Loại bệnh chưa được xóa");
        }


    }
}
