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
                foreach ($treatmentHistoryDetailList as $treatmentHistoryDetail){
                    $treatmentHistoryDetail->step = $treatmentHistoryDetail->hasTreatmentDetailStep()->first()->belongsToStep()->first();
                }



//
//                foreach ($treatmentHistoryDetailList as $treatmentHistoryDetail){
//                    $treatmentHistoryDetail->step = $treatmentHistoryDetail->hasTreatmentDetailStep()->get();
//
//                }

                $treatmentHistory->detailList = $treatmentHistoryDetailList;
                $treatmentHistory->treatment = $treatmentHistory->belongsToTreatment()->first();
                $treatmentHistory->patient = $patient;
                $treatmentHistory->tooth= $treatmentHistory->belongsToTooth()->first();
        }
        dd($treatmentHistoryList);
        return $treatmentHistoryList;
    }

    public function getTreatmentHistories($phone)
    {
        $treatmentHistories = Patient::where('phone', $phone)->first()->hasTreatmentHistory()->get();
        return $treatmentHistories;
    }
}