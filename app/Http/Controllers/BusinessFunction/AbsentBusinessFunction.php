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
use App\RequestAbsent;
use Carbon\Carbon;

trait AbsentBusinessFunction
{
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

    public function getListAbsent()
    {
        return RequestAbsent::all();
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
        return RequestAbsent::where('staff_id', $id);
    }
}