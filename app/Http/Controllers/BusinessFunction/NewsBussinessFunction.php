<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 12-Jun-18
 * Time: 21:13
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Appointment;
use App\Providers\AppServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Mockery\Exception;
use App\Model\News;
use DB;

trait NewsBussinessFunction
{
    public function createNewsBusiness($Newsxx)
    {
        DB::beginTransaction();
        try{

            $News = new News;
            $News->image_header = $Newsxx->image_header ;
            $News->content = $Newsxx->content;
            $News->title =$Newsxx->title;
            $News->staff_id = $Newsxx->staff_id;
            $News->create_date=$Newsxx->create_date;
            $News->save();
            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            return false;

        }

    }
    public function deleteNews($id){
        DB::beginTransaction();
        try{

            $NewsCurrent = News::find($id);
            $NewsCurrent->delete();
            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            return false;

        }
    }
}