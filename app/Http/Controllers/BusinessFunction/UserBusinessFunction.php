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
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

trait UserBusinessFunction
{


    /**
     * @param $phone
     * @param $password
     * @return int
     */
    public function checkLogin($phone, $password)
    {
        try {
            $result = User::where('phone', $phone)->first();
            if ($result != null) {
                if (Hash::check($password, $result->password)) {
                    return $result;
                }
            } else {
                return null;
            }
        } catch (\Exception $exception) {
            Log::info($exception->getTraceAsString());
        }
    }

    public function registerPatient($user, $patient, $userHasRole)
    {
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
    }

    public function registerUser($user)
    {
        DB::beginTransaction();
        try {
            $user->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    } public function updateUser($user)
    {
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

    public function updateUser($user)
    {
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

    public function updatePatient($patient)
    {
        DB::beginTransaction();
        try {
            $patient->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function changeUserPassword($phone, $password)
    {
        DB::beginTransaction();
        try {
            $user = User::where('phone', $phone)->first();
            $user->password = Hash::make($password);
            $user->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function getPatient($phone)
    {
        $patients = Patient::where('phone', $phone)->get();
        if ($patients != null) {
            foreach ($patients as $item) {
                $item->district = $item->belongsToDistrict()->first();
                $item->city = $item->belongsToDistrict()->first()->belongsToCity()->first();
            }
            return $patients;
        }
        return null;
    }

    public function getPatientsByPhone($phone)
    {
        $patient = Patient::where('phone', $phone)->get();
        if ($patient != null) {
            return $patient;
        }
        return null;
    }

    public function getUserByPhone($phone)
    {
        $user = User::where('phone', $phone)->first();
        if ($user != null) {
            return $user;
        }
        return null;
    }

    public function getPatientById($id)
    {
        $patient = Patient::where('id', $id)->first();
        if ($patient != null) {
            return $patient;
        }
        return null;
    }

    public function checkExistUser($phone)
    {
        $user = User::where('phone', $phone)->first();
        if ($user != null) {
            return true;
        }
        return false;
    }

    public function registerStaff($user, $staff, $userHasRole)
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
            return false;
        }
    }

    public function createRole($role)
    {
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

    public function updateRole($role)
    {
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

    public function deleteRole($id)
    {
        DB::beginTransaction();
        try {
            Role::delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }


    public function checkParentOfPatient($phone, $date_of_birth)
    {
        $currentParent = User::where('phone', $phone)->first()->hasPatient()->where('is_parent', 1)->first();
        if ($currentParent->date_of_birth < $date_of_birth) {
            $currentParent->is_parent = 0;
            $currentParent->save();
            return false;
        }
        return true;
    }


    public function editAvatar($image, $id)
    {
        DB::beginTransaction();
        try {
            $patient = Patient::where('id', $id)->first();
            $avatarFolder = '/assets/images/avatar/';
            $path = public_path($avatarFolder);
            $filename = 'user_avatar_' . $id . '.' . $image->getClientOriginalExtension();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $hostname = request()->getHttpHost();
            //get time stamp
            $date = new \DateTime();
            $timestamp = $date->getTimestamp();
            $fullPath = 'http://' . implode('/',
                    array_filter(
                        explode('/', $hostname . $avatarFolder . $filename))
                ) . '?time=' . $timestamp;
            $image->move($path, $filename);
            $patient->avatar = $fullPath;
            $patient->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
            return false;
        }
    }
}