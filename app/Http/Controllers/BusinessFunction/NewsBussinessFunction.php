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

trait NewsBussinessFunction
{
    public function createNews($image_header, $content, $title,$staff_id,$create_date)
    {
        DB::beginTransaction();
        try{

            $News = new News;
            $News->image_header = $image_header ;
            $News->content =  $content;
            $News->title = $title;
            $News->staff_id = $staff_id;
            $News->create_date=$create_date;
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