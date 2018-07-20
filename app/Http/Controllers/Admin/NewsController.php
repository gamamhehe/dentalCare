<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\NewsBussinessFunction;
use App\Model\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Yajra\Datatables\Facades\Datatables;
class NewsController extends Controller
{
    use NewsBussinessFunction;
    public function create(Request $request){
        if( $this->createNews($request->all())){
            return redirect()->route("admin.list.news")->withSuccess("Bài viết đã được tạo");
        }else{
            return redirect('admin/News/list')->withSuccess("Có lỗi xảy ra khi khởi tạo");
        }
    }

    public function getList(Request $request){
        $listNews = $this->getAllNews();
        return Datatables::of($listNews)->addColumn('action', function($listNews) {
                return '<a href="edit-news/'.$listNews->id.'" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Chỉnh sửa</a> <a id="'.$listNews->id.'" onclick="deleteNews(this)" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Xóa</a>';
            })->make(true);

    }
    public function loadList(Request $request){

        return view('admin.News.list');
    }
    public function loadEdit($id){

        $news = $this->getNews($id);
        $content = $news->image_header;
        return view("admin.News.edit",['news'=>$news,'xxx'=>$content]);
    }
    public function edit(Request $request){
        if( $this->editNews($request->all())){
            return redirect()->route("admin.list.news")->withSuccess("Bài viết đã được chỉnh");

        }else{
            return redirect()->back()->withSuccess("Có lỗi xảy ra khi khởi tạo");
        }




    }
    public function delete($id){
       if( $this->deleteNews($id)){
           return redirect('/list-news')->withSuccess("Bài viết đã được xóa");
       }else{
           return redirect('admin/list-news')->withSuccess("Có lỗi xảy ra khi khởi tạo");
       }
    }

}
