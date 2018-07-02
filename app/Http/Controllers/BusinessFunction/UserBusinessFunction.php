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

    public function createUser($user)
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

    public function createUserWithRole($user, $patient, $userHasRole)
    {
        DB::beginTransaction();
        try {
            $user->save();
            $patient->save();
            $userHasRole->save();
            Log::info("LOGOGOOG");
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw new Exception($e->getMessage());
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

    public function getUserByPhone($phone)
    {
        $user = User::where('phone', $phone)->first();
        if ($user != null) {
            return $user;
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