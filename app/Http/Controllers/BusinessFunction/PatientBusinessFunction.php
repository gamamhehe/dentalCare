<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\AnamnesisPatient;
use App\Model\Patient;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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


    public function getPatientByPhone($phone)
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

    public function createPatient($patient)
    {
        DB::beginTransaction();
        try {
            $PatientId = Patient::create([
                'name' => $patient->name,
                'address' => $patient->address,
                'phone' => $patient->phone,
                'avatar' => $patient->avatar,
                'date_of_birth' => $patient->date_of_birth,
                'gender' => $patient->gender,
                'district_id' => $patient->district_id,
            ])->id;
            DB::commit();
            return $PatientId;
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
            throw new \Exception($e->getMessage());
        }
    } public function updatePatientWithAnamnesis($patient,$listAnamnesisId)
    {
        DB::beginTransaction();
        try {
            $patient->save();
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
            throw new \Exception($e->getMessage());
        }
    }

    public function getListPatient()
    {
        return Patient::all();
    }

    public function getPhoneOfPatient($id){
        return Patient::find($id)->phone;
    }
}