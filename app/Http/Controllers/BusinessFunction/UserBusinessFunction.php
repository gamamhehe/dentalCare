<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/10/2018
 * Time: 12:55 AM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\Patient;
use App\Model\Role;
use App\Model\User;
use App\Model\UserHasRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait UserBusinessFunction
{


    /**
     * @param $phone
     * @param $password
     * @return int
     */
    public function checkLogin($phone, $password)
    {
        $result = User::where('phone', $phone)->first();
        if ($result != null) {
            if (Hash::check($password, $result->password)) {
                return $result;
            }
        } else {
            return null;
        }
    }

    public function registerPatient($user, $patient, $userHasRole){
        DB::beginTransaction();
        try {
            $user->save();
            $patient->save();
            $userHasRole->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    } public function registerUser($user){
        DB::beginTransaction();
        try {
            $user->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
    public  function getPatient($phone){
        $patientParent = Patient::where('phone',$phone)->where('is_parent',1)->first();
        $subaccount = Patient::where('phone',$phone)->where('is_parent',0)->get();
        $treatmentHistories = Patient::where('phone',$phone)->first()->hasTreatmentHistory()->get();
        $patientParent->subaccounts = $subaccount;
        $patientParent->treatment_histories = $treatmentHistories;
        return $patientParent;
    }
    public function checkExistUser($phone){
        $user = User::where('phone', $phone)->first();
        if($user != null){
            return true;
        }
        return false;
    }
    public function registerStaff($user, $staff, $userHasRole){
        DB::beginTransaction();
        try {
            $user->save();
            $staff->save();
            $userHasRole->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function createRole($role){
        DB::beginTransaction();
        try {
            $role->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function updateRole($role){
        DB::beginTransaction();
        try {
            $role->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function deleteRole($id){
        DB::beginTransaction();
        try {
            Role::deleted($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}