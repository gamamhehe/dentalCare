<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Patient;
use Exception;
use Illuminate\Support\Facades\DB;

trait PatientBusinessFunction
{
    public function getPatientById($id)
    {
        $patient = Patient::where('id', $id)->first();
        if ($patient != null) {
            return $patient;
        }
        return null;
    }

    public function getPatient($phone)
    {
        $patients = Patient::where('phone', $phone)->get();
        if ($patients != null) {
            foreach ($patients as $item) {
                $district = $item->belongsToDistrict()->first();
                $item->district = $district;
                $item->city = $district == null ? null : $district->belongsToCity()->first();
            }
            return $patients;
        }
        return null;
    }

    public function createPatient($patient, $userHasRole)
    {
        DB::beginTransaction();
        try {
            $patient->save();
            $userHasRole->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function updatePatient($request, $idPatient)
    {
        DB::beginTransaction();
        try {
            $patient = Patient::find($idPatient);
            $patient->name = $request->name;
            $patient->address = $request->address;
            $patient->phone = $request->phone;
            $patient->date_of_birth = $request->date_of_birth;
            $patient->gender = $request->gender;
            $patient->avatar = $request->avatar;
            $patient->district_id = $request->district_id;
            $patient->is_parent = $request->is_parent;
            $patient->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw new Exception($e->getMessage());
        }
    }

    public function updatePatientWithModel($patient)
    {
        DB::beginTransaction();
        try {
            $patient->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw new Exception($e->getMessage());
        }
    }

    public function getListPatient()
    {
        return Patient::all();
    }
}