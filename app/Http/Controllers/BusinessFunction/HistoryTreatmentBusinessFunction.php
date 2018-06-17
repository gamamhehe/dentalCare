<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 16-Jun-18
 * Time: 18:48
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Patient;
use App\Model\TreatmentHistory;

trait HistoryTreatmentBusinessFunction
{
    public function getAllHistoryTreatments()
    {
        $historyTreatments = TreatmentHistory::all();
        return $historyTreatments;
    }

    public function getHistoryTreatmentByPhone($phone)
    {
        $historyTreatments = TreatmentHistory::where('phone', $phone)->get();
        foreach ($historyTreatments as $item) {
            $item->treatment_details = $item->hasTreatmentDetail();
        }
        return $historyTreatments;
    }

    public function getHistoryTreatmentById($id)
    {
        $historyTreatments = TreatmentHistory::where('id', $id)->get();
        foreach ($historyTreatments as $item) {
            $item->treatment_details = $item->hasTreatmentDetail();
        }
        return $historyTreatments;
    }
}