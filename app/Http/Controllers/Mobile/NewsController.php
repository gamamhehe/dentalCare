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

}