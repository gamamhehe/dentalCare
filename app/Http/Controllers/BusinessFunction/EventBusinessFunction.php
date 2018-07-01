<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Absent;
use App\Model\Event;
use App\Model\Feedback;
use App\Model\Role;
use App\Model\News;
use App\Model\NewsType;
use App\Model\Type;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

trait EventBusinessFunction
{
    public function createEventBusiness($EventBusinessFunction){
        DB::beginTransaction();
        try{
            $NewEvent = new Event();
            $NewEvent->name =  $Event['name'];
            $NewEvent->discount = (int)  $Event['discount'];
            $NewEvent->treatment_id = (int)$Event['listTreatment'];
            $NewEvent->start_date=Carbon::now();
            $NewEvent->end_date=Carbon::now();
            $NewEvent->create_date=Carbon::now();
            $NewEvent->staff_id=1;

            $NewEvent->save();
            DB::commit();

            return true;

        }catch(\Exception $e){
            dd($e);
            DB::rollback();
            return false;

        }

    }
    public function deleteEventBusiness($id){
        DB::beginTransaction();
        try{
            $NewEvent = Event::where('id', $id)->first();
            $NewEvent->delete();
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollback();
            return false;

        }
    }

    public function checkDiscount($idTreatment)
    {
        $event = Event::where('treatment_id', '=', $idTreatment)
            ->where('start_date', '<', Carbon::now())
            ->where('end_date', '>', Carbon::now())
            ->get();
        if($event){
            return $event->discount;
        }else return 0;
    }
    public function getListEvent(){
       $typeNews =  NewsType::where('type_id',2)->get();
        $event=[];
        foreach($typeNews as $x)
        {
            $event[]= $x->belongsToNews()->first();
        }
        dd($event);
        return $event;
    }
     public function getTopEvent(){
        $event = Event::all();
        dd($event);
        return $event;
    }
}