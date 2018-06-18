<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/14/2018
 * Time: 8:11 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\Patient;
use App\Model\TreatmentHistory;
use App\Model\User;

trait TreatmentBusinessFunction
{
    public function getTreatmentHistory($id)
    {
        $listResult = [];
        $patient = Patient::where('id',$id)->first();
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
        $dentist =$treatmentHistoryList[0];
            dd($dentist);
//        dd($treatmentHistoryList);

        return $treatmentHistoryList;
    }

    public function  getTreatmentHistories($phone){
        $treatmentHistories = Patient::where('phone',$phone)->first()->hasTreatmentHistory()->get();
        return $treatmentHistories;
    }
}