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
        $user = User::where('phone', $value->phone)->first();
        if($user != null){
            return 'User with this phone is exist';
        }
        DB::beginTransaction();
        try {
            User::create([
                'phone' => $value->phone,
                'password' => Hash::make($value->phone),
                'isDeleted' => false
            ]);
            Patient::create($value);
            UserHasRole::create([
                'phone' => $value->phone,
                'role_id' => 4,
                'start_time' => Carbon::now(),
                'end_time' => null
            ]);
            DB::commit();
            return 'Create success';
        } catch (\Exception $e) {
            DB::rollback();
            return 'Create fail';
        }
    }

    public function registerStaff($value, $role){
        $user = User::where('phone', $value->phone)->first();
        if($user != null){
            return 'User with this phone is exist';
        }
        DB::beginTransaction();
        try {
            User::create([
                'phone' => $value->phone,
                'password' => Hash::make($value->phone),
                'isDeleted' => false
            ]);
            Staff::create($value);
            UserHasRole::create([
                'phone' => $value->phone,
                'role_id' => $role,
                'start_time' => Carbon::now(),
                'end_time' => null
            ]);
            DB::commit();
            return 'Create success';
        } catch (\Exception $e) {
            DB::rollback();
            return 'Create fail';
        }
    }

    public function createRole($value){
        DB::beginTransaction();
        try {
            Role::create($value);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function updateRole($role){
        $role->save();
        return true;
    }

    public function deleteRole($role){
        $role->save();
        return true;
    }
}