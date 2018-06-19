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
    public function createAnamnesis(Request $request){

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

    public function getListAnamnesis(Request $request){
        $AnamnesisCatalog = AnamnesisCatalog::all();

        return Datatables::of($AnamnesisCatalog)
            ->addColumn('action', function($AnamnesisCatalog) {
                return '<a href="editAnamnesis/'.$AnamnesisCatalog->id.'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Edit</a> <a id="'.$AnamnesisCatalog->id.'" onclick="deleteAnamnesis(this)" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Delete</a>';
            })->make(true);

    }
    public function loadcreateAnamnesis(Request $request){
        return view('admin.anamnesis.create');
    }
    public function loadListAnamnesis(Request $request){
//
        return view('admin.anamnesis.list');
    }
    public function loadEditAnamnesis($id){

        $AnamnesisCatalog = AnamnesisCatalog::find($id);

        $content = $AnamnesisCatalog->image_header;
        return view("admin.anamnesis.edit",['AnamnesisCatalog'=>$AnamnesisCatalog,'xxx'=>$content]);
    }
//    public function createdNews(Request $request){
//
//        $input = $request->all();
//        DB::beginTransaction();
//        try{
//            $NewsCurrent = News::find($input['News_id']);
//            $NewsCurrent->image_header = $input['image_header'];
//            $NewsCurrent->content = $input['content'];
//            $NewsCurrent->title = $input['title'];
//            $NewsCurrent->save();
//            DB::commit();
//            return redirect()->route("admin.list.news")->withSuccess("Bài viết đã được chỉnh");
//
//        }catch(\Exception $e){
//            DB::rollback();
//            return redirect()->back()->withSuccess("Bài viết chưa được chỉnh");
//
//        }
//
//
//    }
//    public function deleteNews($id){
//        $News = $this->deleteNews($id);
//        dd($News);
//        if($News){
//            return redirect('/list-News')->withSuccess("Bài viết đã được xóa");
//        }else{
//            return redirect('/list-News')->withSuccess("Bài viết chưa được xóa");
//        }
//
//
//    }
}
