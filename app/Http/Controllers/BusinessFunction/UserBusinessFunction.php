<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/10/2018
 * Time: 12:55 AM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Helpers\AppConst;
use App\Model\AnamnesisPatient;
use App\Model\FirebaseToken;
use App\Model\Patient;
use App\Model\Role;
use App\Model\User;
use App\Model\UserHasRole;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

    public function createUser($user,$userHasRole)
    {
        DB::beginTransaction();
        try {
            $user->save();
            $userHasRole->save();
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
    

    public function createUserWithAnamnesis($user, $patient, $userHasRole, $listAnamnesisId)
    {
        DB::beginTransaction();
        try {
            $user->save();
            $patient->save();
            $userHasRole->save();
            if ($listAnamnesisId != null) {
                foreach ($listAnamnesisId as $id) {
                    $anamnesis = new AnamnesisPatient();
                    $anamnesis->anamnesis_id = $id;
                    $anamnesis->patient_id = $patient->id;
                    $anamnesis->save();
                }
            }
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
        return $user;
    }

    public function getUserFirebaseToken($phone)
    {
        $token = FirebaseToken::where('phone', $phone)->first();
        return $token;
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

    public function updateUserFirebaseToken($phone, $token)
    {
        try {
            $userToken = FirebaseToken::where('phone', $phone)->first();
            if ($userToken == null) {
                $userToken = new FirebaseToken();
            }
            $userToken->noti_token = $token;
            $userToken->phone = $phone;
            $userToken->save();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getPrevious());
        }
    }

    public function getUserPatientPhones($keyword)
    {
        $phones = User::where('phone', 'like', '%' . $keyword . '%')
            ->pluck('phone')
            ->toArray();
        $result = [];
        foreach ($phones as $phone) {
            $uHasRole = UserHasRole::where('phone', $phone)
                ->where('role_id', AppConst::ROLE_PATIENT)
                ->first();
            if ($uHasRole != null) {
                $result [] = $phone;
            }
        }
        return $result;
    }


    public function getUserApptByDate($phone, $dateStr, $orderBy = 'asc')
    {
        $user = User::where('phone', $phone)->first();
        $appointments = $user->hasAppointment()
            ->whereDate('start_time', $dateStr)
            ->orderBy('numerical_order', $orderBy)
            ->get();
        return $appointments;
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

    public function isRoleStaff($phone)
    {
        $staff = User::where('phone', $phone)->first();
        if ($staff == null) {
            return false;
        }
        $hasRoles = $staff->hasUserHasRole()->get();
        foreach ($hasRoles as $role) {
            if ($role->role_id == 4) {
                return false;
            }
        }
        return true;
    }
    public function createAccountNewMember($phone){
        $user = User::where('phone', $phone)->first();
        
        if($user == null){// không có
            $user = new User();
            $user->phone = $phone;
            $user->password = Hash::make($phone);
            $userHasRole = new UserHasRole();
            $userHasRole->phone = $phone;
            $userHasRole->role_id = 4;
            $userHasRole->start_time = Carbon::now();

            $resultXX = $this->createUser($user,$userHasRole);
            if($resultXX){
                return true;
            }else{
                return false;
            }
        }else{//có
            return true;
        }
    }
     public function checkNewMember($phone){
        $result = User::where('phone', $phone)->first();
        if($result != null){
            return false;
        }else{
            return true;
        }
    }

    public function editAvatar($image, $profileId, $forWho = "user")
    {
        DB::beginTransaction();
        try {
            $patient = Patient::where('id', $profileId)->first();
            $avatarFolder = '/assets/images/avatar/';
            $path = public_path($avatarFolder);
            $filename = $forWho . '_avatar_' . $profileId . '.' . $image->getClientOriginalExtension();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            //get time stamp
            $date = new \DateTime();
            $timestamp = $date->getTimestamp();
            $fullPath =  implode('/',
                    array_filter(
                        explode('/',  $avatarFolder . $filename))
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