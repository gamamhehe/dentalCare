<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:47 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\Role;
use App\Model\Absent;
use App\Model\Staff;
use App\Model\UserHasRole;
use App\RequestAbsent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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


}