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
use App\Model\NewsType;
use App\Model\Type;
use App\Providers\AppServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

trait NewsBussinessFunction
{
    public function createNewsBusiness($Newsxx)
    {
        DB::beginTransaction();
        try {
            $News = new News;
            $News->image_header = $Newsxx->image_header;
            $News->content = $Newsxx->content;
            $News->title = $Newsxx->title;
            $News->staff_id = $Newsxx->staff_id;
            $News->create_date = $Newsxx->create_date;
            $News->save();
            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }

    }

    public function getMoreNews($currentIndex, $numItem, $typeId)
    {
        $data = Type::where('id',$typeId)->first()
            ->hasNewsType()
            ->skip($currentIndex)
            ->take($numItem)
            ->get();
        $listNews = [];
        foreach ($data as $item) {
            $listNews[] = $item->belongsToNews()->first();
        }
        foreach ($listNews as $item) {
            $item->staff = $item->belongsToStaff()->first();
        }
        return $listNews;
    }

    public function getNews($id)
    {
        $News = News::find($id);
        return $News;
    }

    public function getAllNews()
    {
        $listNews = News::all();
        return $listNews;
    }

    public function deleteNews($id)
    {
        DB::beginTransaction();
        try {

            $NewsCurrent = News::where('id', $id)->first();
            $NewsCurrent->delete();
            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }
    }
    public function getListNewsOfEvent(){
        $typeNews =  NewsType::where('type_id',2)->get();
        $event=[];
        foreach($typeNews as $x)
        {
            $event[]= $x->belongsToNews()->first();
        }
        
       return $event;
    }
    public function getNewestNews(){
        $typeNews =  NewsType::where('type_id',2)->get();
        $event=[];
        foreach($typeNews as $x)
        {
            $event[]= $x->belongsToNews()->first();
        }
        $largestID=0;
        if($event){
                foreach ($event as $key ) {
                $term = $key->id;
                $largestID = max($largestID,$term);
                }
            $newestEvent = News::where('id', $largestID)->first(); 

            return $newestEvent;    
        }else{
             $newestEvent = News::where('id',1)->first(); 
            return $newestEvent;
        }


       
    }
}