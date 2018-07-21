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
    public function getAllEvent(){
        $listEvent = Event::all();
        return $listEvent;
    }
    public function getEventByID($id){
        $listEvent = Event::find($id);
        return $listEvent;
    }
    public function editEvent($input,$id){
        DB::beginTransaction();
        try{
            $Event = Event::find($id);
            $Event->name =  $input['name'];
            $Event->discount =(int) $input['discount'];
            $Event->treatment_id =(int)$input['listTreatment'];
            $Event->start_date=Carbon::now();
            $Event->end_date=Carbon::now();
            $Event->staff_id=1;
            $Event->save();
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollback();
            return false;

        }
    }
    //xxxx
    public function createEvent($input){
        DB::beginTransaction();
        try{
            $Event = new Event();
            $Event->name = $input['name'];
            $Event->start_date=Carbon::now();
            $Event->end_date=Carbon::now();
            $Event->discount =(int) $input['discount'];
            $Event->staff_id=1;
            $Event->treatment_id =$input['listTreatment'];
            $Event->created_date=Carbon::now();


            $Event->save();
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
        $listEvent = Event::where('treatment_id', '=', $idTreatment)
            ->where('start_date', '<', Carbon::now())
            ->where('end_date', '>', Carbon::now())
            ->get();
        if($listEvent){
            $result = 0;
            foreach ($listEvent as $event){
                $result += $event->discount;
            }
            return $result;
        }else return 0;
    }
    public function getListEvent(){
       $typeNews =  NewsType::where('type_id',2)->get();
        $event=[];
        foreach($typeNews as $x)
        {
            $event[]= $x->belongsToNews()->first();
        }
        return $event;
    }
     public function getTopEvent(){
        $event = Event::all();
        dd($event);
        return $event;
    }
}