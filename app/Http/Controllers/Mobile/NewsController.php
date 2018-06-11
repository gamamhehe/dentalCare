<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 06-Jun-18
 * Time: 13:08
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;
use App\Model\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Carbon\Carbon;
class NewsController extends Controller
{

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
//        return response()->json(["n"=>$currentIndex,"n2"=>$numItem],200);
        try {
            $data = News::skip($currentIndex)->take($numItem)->get();
            return response()->json($data, 200);
        } catch (Exception $ex) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra";
            $error->exception = $ex;
            return response()->json($error, 500);
        }
    }
    public function loadcreateNews(Request $request){
        return view('admin.News.createNews');
    }
    public function createNews(Request $request){
        // $this->validate($request, [
        //     'image_header' => 'required',
        //     'title' => 'required|min:6',
        //     'content' => 'required|min:6'

        // ]);
        $mess = "ahihi";
        DB::beginTransaction();
        try{
            $input = $request->all();
            $News = new News;
            $News->image_header = $input['image_header'];
            $News->content =  $input['content'];
            $News->title = $input['title'];
            $News->staff_id = 1;
            $News->create_date=Carbon::now();
            $News->save();
            DB::commit();
            return redirect('/list-News')->withSuccess("ssss");
             // return redirect('/list-News');
          // return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->withSuccess("NOT");
             
        }
    }

    public function loadListNews(Request $request){
        return view('admin.News.ListNews');
    }

}