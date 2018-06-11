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

    public function registerPatient($value){
        DB::beginTransaction();
        try {
            User::create([
                'phone' => $value->phone,
                'password' => Hash::make($value->phone),
                'isDeleted' => false
            ]);
            Patient::created($value);
            UserHasRole::created([
                'phone' => $value->phone,
                'role_id' => 4,
                'start_time' => Carbon::now(),
                'end_time' => null
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function registerStaff($value, $role){
        DB::beginTransaction();
        try {
            User::create([
                'phone' => $value->phone,
                'password' => Hash::make($value->phone),
                'isDeleted' => false
            ]);
            Staff::created($value);
            UserHasRole::created([
                'phone' => $value->phone,
                'role_id' => $role,
                'start_time' => Carbon::now(),
                'end_time' => null
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function createRole($value){
        DB::beginTransaction();
        try {
            Role::created($value);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}