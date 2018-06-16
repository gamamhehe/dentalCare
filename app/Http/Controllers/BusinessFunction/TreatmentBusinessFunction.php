<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/14/2018
 * Time: 8:11 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\User;

trait TreatmentBusinessFunction
{
    public function getTreatmentHistory($phone)
    {
        $listResult = [];
        $patientList = User::where('phone', $phone)->first()->hasPatient()->get();
        foreach ($patientList as $patient) {
            $treatmentHistoryList = $patient->hasTreatmentHistory()->get();
            foreach ($treatmentHistoryList as $treatmentHistory) {
                $treatmentHistoryDetailList = $treatmentHistory->hasTreatmentDetail()->get();
                foreach ($treatmentHistoryDetailList as $treatmentHistoryDetail){
                    $treatmentHistoryDetail->dentist_id = $treatmentHistoryDetail->belongsToStaff()->first();
                }
                $treatmentHistory->detailList = $treatmentHistoryDetailList;
                $treatmentHistory->treatment_id = $treatmentHistory->belongsToTreatment()->first();
                $treatmentHistory->patient_id = $patient->first();
            }
            if ($patient->is_parent == 1) {
                array_unshift($listResult, $treatmentHistoryList);
            }
            else{
                $listResult[] = $treatmentHistoryList;
            }
        }
        dd($listResult);
    }
}