<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 12-Jun-18
 * Time: 21:13
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Appointment;
use App\Model\News;
use App\Providers\AppServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

trait NewsBussinessFunction
{

    public function getMoreNews($currentIndex, $numItem,$typeId)
    {
        $listNews = DB::table('tbl_news')
            ->join('tbl_news_types','tbl_news_types.news_id','=','tbl_news.id')
            ->select('tbl_news.*')
            ->where('tbl_news_types.type_id','=',$typeId)
            ->skip($currentIndex)
            ->take($numItem)
            ->get();
        return $listNews;
    }

    public function getAllNews(){
        $listNews = News::all();
        return $listNews;
    }

}