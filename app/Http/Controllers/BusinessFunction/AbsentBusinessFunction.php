<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Absent;
use App\Model\Role;
use App\Model\RequestAbsent;
use Carbon\Carbon;
use DB;
trait AbsentBusinessFunction
{

    public function checkAbsentForStaffWasApprove($staff,$start_date,$end_Date){
        $result = $this->getListAbsentApproveStaff($staff->id);
        foreach ($result as $key => $value) {
           if((new Carbon($start_date))->format('Y-m-d') >= (new Carbon($value->start_date))->format('Y-m-d') &&  (new Carbon($start_date))->format('Y-m-d') <=(new Carbon($value->end_date))->format('Y-m-d') ){
               return false;
           }//start

           if((new Carbon($value->start_date))->format('Y-m-d') <= (new Carbon($end_Date))->format('Y-m-d') &&(new Carbon($value->end_date))->format('Y-m-d') >= (new Carbon($end_Date))->format('Y-m-d')){
             return false;
           }//end
           if((new Carbon($value->start_date))->format('Y-m-d') >= (new Carbon($start_date))->format('Y-m-d') && (new Carbon($value->end_date))->format('Y-m-d')  <= (new Carbon($end_Date))->format('Y-m-d') ){
           return false;
           }//all
            
        }
       return true;
         

    }
   public function checkExistAbsentStaff($staff, $start_date, $end_Date)
    {
        $checkExistAbsentStaff = RequestAbsent::where('staff_id', $staff->id)
            ->get()->where('end_date', '>', $start_date->format("Y-m-d"))
            ->get()->where('end_date', '>', Carbon::now())
            ->get();
        if ($checkExistAbsentStaff != null)
            return false;
        else
            return true;
    }


    public function createAbsent($staff, $start_date, $end_date, $reason)
    {
        DB::beginTransaction();
        try {
            RequestAbsent::create([
                'staff_id' => $staff,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'reason' => $reason,
            ]);
            DB::commit();
             return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function getListAbsentNotApprove()
    {
        $listAbsent = RequestAbsent::all();
        $result = [];
        foreach ($listAbsent as $absent) {
            if ($absent->hasAbsent()->first() == null) {
                $result[] = $absent;
            }
        }
        return $result;
    }
    public function getListAbsentApproveStaff($staff_id){
        $listAbsent = RequestAbsent::where('staff_id',$staff_id)->get();
        $result = [];
        foreach ($listAbsent as $absent) {
            if($absent->hasAbsent()->first() !=null){
            $result[] = $absent;   
            }
        }
        return $result;
    }

    public function getListAbsent()
    {
        return RequestAbsent::all();
    }
    public function getListAbsentByAdmin()
    {
        $x =  RequestAbsent::all();
        foreach ($x as $key ) {
            $key->nameStaff = $key->belongsToStaff()->first()->name;
            $key->status = $key->hasAbsent()->first();
        }
        return $x;
        
    }
    public function getListAbsentByStaff($id)
    {
        $x =  RequestAbsent::where('staff_id',$id)->get();
        foreach ($x as $key ) {
            $key->status = $key->hasAbsent()->first();
        }
        return $x;
    }
    public function getListAbsentByStaffNotApprove($id)
    {
       $listAbsent = RequestAbsent::where('staff_id',$id)->get();
        $result = [];
        foreach ($listAbsent as $absent) {
            if($absent->hasAbsent()->first() ==null){
            $result[] = $absent;   
            }
        }
        return $result;
    }

    public function approveAbsent($idAbsent, $idAdmin, $message)
    {
        DB::beginTransaction();
        try {
            Absent::create([
                'staff_approve_id' => $idAdmin,
                'request_absent_id' => $idAbsent,
                'message_from_staff' => $message
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public  function showListAbsentOfStaff($id){
        return RequestAbsent::where('staff_id', $id)->get();
    }
    public  function deleteAbsentById($id){
        DB::beginTransaction();
        try {
            $RequestAbsent = RequestAbsent::where('id', $id)->first();
            $RequestAbsent->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
    public function getAbsentById($id){
        return RequestAbsent::where('id',$id)->first();
    }
}