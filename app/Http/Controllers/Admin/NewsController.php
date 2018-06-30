<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\NewsBussinessFunction;
use App\Model\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\Datatables\Facades\Datatables;
use DB;
class NewsController extends Controller
{
    use NewsBussinessFunction;
    public function create(Request $request){

        $input = $request->all();

        $News = new News;
        $News->image_header = $input['image_header'];
        $News->content =  $input['content'];
        $News->title = $input['title'];
        $News->staff_id = 1;
        $News->create_date=Carbon::now();
        $Newsxxx = $this->createNewsBusiness($News);
        if($Newsxxx){
            return redirect()->route("admin.list.news")->withSuccess("Bài viết đã được tạo");
        }else{
            return redirect('admin/News/list')->withSuccess("Bài viết chưa được tạo");
        }


    }

    public function getList(Request $request){
        $listNews = News::all();

        return Datatables::of($listNews)
            ->addColumn('action', function($listNews) {
                return '<a href="editNews/'.$listNews->id.'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Edit</a> <a id="'.$listNews->id.'" onclick="deleteNews(this)" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Delete</a>';
            })->make(true);

    }
    public function loadList(Request $request){
//            return redirect("admin.News.list");
        return view('admin.News.list');
    }
    public function loadEdit($id){

        $news = News::find($id);

        $content = $news->image_header;
        return view("admin.News.edit",['news'=>$news,'xxx'=>$content]);
    }
    public function created(Request $request){

        $input = $request->all();
        DB::beginTransaction();
        try{
            $NewsCurrent = News::find($input['News_id']);
            $NewsCurrent->image_header = $input['image_header'];
            $NewsCurrent->content = $input['content'];
            $NewsCurrent->title = $input['title'];
            $NewsCurrent->save();
            DB::commit();
            return redirect()->route("admin.list.news")->withSuccess("Bài viết đã được chỉnh");

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->withSuccess("Bài viết chưa được chỉnh");

        }


    }
    public function delete($id){
       $News = $this->deleteNews($id);
       dd($News);
       if($News){
           return redirect('/list-News')->withSuccess("Bài viết đã được xóa");
       }else{
           return redirect('/list-News')->withSuccess("Bài viết chưa được xóa");
       }


    }
}
