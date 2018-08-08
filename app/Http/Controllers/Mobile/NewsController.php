<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 06-Jun-18
 * Time: 13:08
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\NewsBussinessFunction;
use App\Http\Controllers\Controller;
use App\Model\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Carbon\Carbon;
use Yajra\Datatables\Facades\Datatables;
class NewsController extends Controller
{
use NewsBussinessFunction;
    /**
     * @param
     * @return
     */
    public function getAllNews()
    {
        $news = News::all();
        return response()->json($news, 200);

    }

    public function loadMore(Request $request)
    {
        $currentIndex = $request->query('currentIndex');
        $numItem = $request->query('numItem');
        $typeId = $request->query('typeId');
//        return response()->json(["n"=>$currentIndex,"n2"=>$numItem],200);
        try {
            $data = $this->getMoreNews($currentIndex,$numItem,$typeId);

            return response()->json($data, 200);
        } catch (Exception $ex) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra";
            $error->exception = $ex;
            return response()->json($error, 500);
        }
    }
    public function loadcreateNews(Request $request){
        return view('admin.News.create');
    }
    public function createNews(Request $request){
        $input = $request->all();
        DB::beginTransaction();
        try{

            $News = new News;
            $News->image_header = $input['image_header'];
            $News->content =  $input['content'];
            $News->title = $input['title'];
            // $News->staff_id = $staffId;
            $News->staff_id = 1;
            $News->created_date=Carbon::now();
            $News->save();
            DB::commit();
            return redirect('/list-News')->withSuccess("Bài viết đã được tạo");

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->withSuccess("Bài viết chưa được tạo");

        }
    }
    public function getListNew(Request $request){
          $listNews = DB::table('tbl_News')->get();

            return Datatables::of($listNews)
     ->addColumn('action', function($listNews) {
    return '<a href="/editNews/'.$listNews->id.'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Edit</a> <a id="'.$listNews->id.'" onclick="deleteNews(this)" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Delete</a>';
      })->make(true);

    }
    public function loadListNews(Request $request){
       
        return view('admin.News.ListNews');
    }
    public function loadEditNews($id){
        $news = DB::table('tbl_news')->where('tbl_news.id','=',$id)->first();
        $content = $news->image_header;
        
        return view("admin.News.editNews",['news'=>$news,'xxx'=>$content]);
    }
    public function createdNews(Request $request){
        $input = $request->all();
        DB::beginTransaction();
        try{
           
            $NewsCurrent = News::find($input['id']);
            $NewsCurrent->image_header = $input['image_header'];
            $NewsCurrent->content = $input['content'];
            $NewsCurrent->title = $input['title'];
            $NewsCurrent->save();
            DB::commit();
            return redirect('/list-News')->withSuccess("Bài viết đã được chỉnh");
          
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->withSuccess("Bài viết chưa được chỉnh");
             
        }
         
    }
    public function deleteNews($id){
         DB::beginTransaction();
        try{
           
            $NewsCurrent = News::find($id);
            $NewsCurrent->delete();
            DB::commit();
            return redirect('/list-News')->withSuccess("Bài viết đã được xóa");
          
        }catch(\Exception $e){
            DB::rollback();
            return redirect('/list-News')->withSuccess("Bài viết chưa được xóa");
             
        }
    }


}