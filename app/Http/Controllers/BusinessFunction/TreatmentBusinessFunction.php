<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/14/2018
 * Time: 8:11 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\Patient;
use App\Model\Payment;
use App\Model\TreatmentHistory;
use App\Model\User;

trait TreatmentBusinessFunction
{
    public function getTreatmentHistory($id)
    {
        $listResult = [];

        $patient = Patient::where('id', $id)->first();
        $treatmentHistoryList = $patient->hasTreatmentHistory()->get();

        foreach ($treatmentHistoryList as $treatmentHistory) {
            $treatmentHistoryDetailList = $treatmentHistory->hasTreatmentDetail()->get();
            foreach ($treatmentHistoryDetailList as $treatmentHistoryDetail) {
                $treatmentHistoryDetail->dentist = $treatmentHistoryDetail->belongsToStaff()->first();
            }
            $treatmentHistory->details = $treatmentHistoryDetailList;
            $treatmentHistory->treatment = $treatmentHistory->belongsToTreatment()->first();
            $treatmentHistory->patient = $patient;
            $treatmentHistory->payment = $treatmentHistory->belongsToPayment()->first();
        }


        return $treatmentHistoryList;
    }

    public function getTreatmentHistoryByPatientId($id)
    {
        $patient = Patient::where('id', $id)->first();
        if($patient!=null){
            $treatmentHistories = $patient->hasTreatmentHistory()->get();
            return $treatmentHistories;
        }
        return null;
    }

    public function getTreatmentHistories($phone)
    {
        $treatmentHistories = Patient::where('phone', $phone)->first()->hasTreatmentHistory()->get();
        return $treatmentHistories;
    }
}