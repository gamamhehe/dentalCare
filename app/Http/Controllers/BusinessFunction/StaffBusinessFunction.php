<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:47 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\RequestAbsent;
use App\Model\Role;
use App\Model\Absent;
use App\Model\Staff;
use App\Model\TreatmentDetail;
use App\Model\UserHasRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait StaffBusinessFunction
{

    public function createStaff($staff, $userHasRole)
    {
        DB::beginTransaction();
        try {
            $staff->save();
            $userHasRole->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function getStaffForDataTable()
    {
        $staffs = Staff::all();
        foreach ($staffs as $staff) {
            $staff->hasUserHasRole = $staff->belongsToUser()->first()->hasUserHasRole()->get();
            $staffName = "";
            foreach ($staff->hasUserHasRole as $key) {
                $key->roleName = $key->belongsToRole()->first()->name;
                if (strlen($staffName) == 0) {
                    $staffName = $staffName . " " . $key->roleName;
                } else {
                    $staffName = $staffName . " - " . $key->roleName;
                }
            }
            $staff->RoleStaff = $staffName;
        }
        return $staffs;
    }

    public function updateStaff($request, $idStaff)
    {
        DB::beginTransaction();
        try {
            $staff = Staff::find($idStaff);
            $staff->name = $request->name;
            $staff->address = $request->address;
            $staff->phone = $request->phone;
            $staff->date_of_birth = $request->date_of_birth;
            $staff->gender = $request->gender;
            $staff->avatar = $request->avatar;
            $staff->district_id = $request->district_id;
            $staff->degree = $request->degree;
            $userHasRole = UserHasRole::where('phone', $request->phone);
            if ($userHasRole->role_id != $request->role_id) {
                $userHasRole->end_time = Carbon::now();
                $userHasRole = new UserHasRole();
                $userHasRole->phone = $request->phone;
                $userHasRole->role_id = $request->role_id;
                $userHasRole->start_time = Carbon::now();
                $userHasRole->save();
            }
            $staff->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function updateStaffProfile($staff)
    {
        DB::beginTransaction();
        try {
            $staff->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function getStaffProfileByPhone($phone)
    {
        $staff = Staff::where('phone', $phone)->first();
        return $staff;

    }

    public function getStaffById($id)
    {
        $staff = Staff::where('id', $id)->first();
        return $staff;
    }

    public function getStaffByName($name)
    {
        $staff = Staff::where('name', 'like', $name)->first();
        return $staff;
    }

    public function getListStaff()
    {
        return Staff::all();
    }

    public function getListDentist()
    {
        $dentist = [];
        $staffs = $this->getListStaff();
        foreach ($staffs as $staff) {
            $staff->role = $staff->belongsToUser()->first()->hasUserHasRole()->get();
            foreach ($staff->role as $key) {
                if ($key->role_id == 2) {
                    $dentist[] = $staff;
                }
            }
        }
        return $dentist;
    }

    public function getListStaffRequestAbsent($staffId)
    {
        $staff = Staff::where('id', $staffId)->first();
        $absentObjs = $staff->hasAbsent()
            ->where('is_deleted', 0);;
        if ($absentObjs != null) {
            $listReqAbsent = $absentObjs->get();
            foreach ($listReqAbsent as $reqAbsent) {
                $absent = $reqAbsent->hasAbsent()->first();
                if ($absent != null) {
                    $reqAbsent->staff_approve = $absent->belongsToStaff() == null ?
                        null : $absent->belongsToStaff()->first();
                    $reqAbsent->message_from_staff = $absent->message_from_staff;
                    $reqAbsent->created_time = $absent->created_time;
                    $reqAbsent->is_approved = $absent->is_approved == null ? 0 : $absent->is_approved;
                } else {
                    $reqAbsent->staff_approve = null;
                    $reqAbsent->message_from_staff = null;
                    $reqAbsent->created_time = null;
                    $reqAbsent->is_approved = 0;
                }
            }
            return $listReqAbsent;
        } else {
            return null;
        }
    }

    public function getListStaffRequestAbsentByTime($staffId, $monthInNumber, $yearInNumber)
    {
        $staff = Staff::where('id', $staffId)->first();
        $absentObjs = $staff->hasAbsent()
            ->whereMonth('start_date', $monthInNumber)
            ->whereYear('start_date', $yearInNumber)
            ->where('is_deleted', 0);
        if ($absentObjs != null) {
            $listReqAbsent = $absentObjs->get();
            Log::info("COUNT: >>>>" . (count($listReqAbsent)));
            foreach ($listReqAbsent as $reqAbsent) {
                $absent = $reqAbsent->hasAbsent()->first();
                if ($absent != null) {
                    $reqAbsent->staff_approve = $absent->belongsToStaff() == null ?
                        null : $absent->belongsToStaff()->first();
                    $reqAbsent->message_from_staff = $absent->message_from_staff;
                    $reqAbsent->created_time = $absent->created_time;
                    $reqAbsent->is_approved = ($absent->is_approved == null ? 0 : $absent->is_approved);
                } else {
                    $reqAbsent->staff_approve = null;
                    $reqAbsent->message_from_staff = null;
                    $reqAbsent->created_time = null;
                    $reqAbsent->is_approved = 0;
                }
            }
            return $listReqAbsent;
        } else {
            return null;
        }
    }


    public function getPatientTreatmentHistory($staffId, $patientId, $dateStr)
    {
        $tmDetails = TreatmentDetail::where('staff_id', $staffId)
            ->whereDate('created_date', $dateStr)
            ->get();
        Log::info('SIZE ' . json_encode($tmDetails));
        $tmHistories = [];
        foreach ($tmDetails as $detail) {
            $tmHistory = $detail->belongsToTreatmentHistory()
                ->where('patient_id', $patientId)
                ->first();
            if ($tmHistory != null) {
                $tmHistories[] = $tmHistory;
            }
        }
        return $tmHistories;
    }
    public function createStaffWithRole($user, $staff, $userHasRole)
    {
        DB::beginTransaction();
        try {
            $user->save();
            $staff->save();
            $userHasRole->save();
            
            DB::commit();
            return true;
        } catch (\Exception $e) {

            DB::rollback();
             dd($e);
            return false;
        }
    }
}