<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 20-Jul-18
 * Time: 22:31
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\RequestAbsent;
use Illuminate\Support\Facades\DB;

trait RequestAbsentBusinessFunction
{
    public function getAllReqAbsent()
    {
        $listRequestAbsent = RequestAbsent::all();
        return $listRequestAbsent;
    }

    public function getReqAbsentById($id)
    {
        $requestAbsent = RequestAbsent::where('id', $id)->first();
        return $requestAbsent;
    }

    public function createListRequestAbsent($listRequestAbsent)
    {
        DB::BeginTransaction();
        try {

            foreach ($listRequestAbsent as $requestAbsent) {
                $requestAbsent->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollback();
            throw new \Exception($ex->getMessage());
        }
    }

    public function createRequestAbsent($requestAbsent)
    {
        try {
            $requestAbsent->save();
            return $requestAbsent;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function updateRequestAbsent($requestAbsent)
    {
        try {
            $requestAbsent->save();
            return true;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function getAbsentObject($reqAbsentObj)
    {
        $absent = $reqAbsentObj->hasAbsent()->first();
        if ($absent != null) {
            $reqAbsentObj->staff_approve = $absent->belongsToStaff() == null ?
                null : $absent->belongsToStaff()->first();
            $reqAbsentObj->message_from_staff = $absent->message_from_staff;
            $reqAbsentObj->created_time = $absent->created_time;
            $reqAbsentObj->status = $absent->status;
        }
        return $absent;
    }
}