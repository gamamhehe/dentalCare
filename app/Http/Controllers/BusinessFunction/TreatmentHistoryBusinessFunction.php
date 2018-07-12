<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/14/2018
 * Time: 8:11 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\Patient;
use App\Model\Treatment;
use App\Model\TreatmentDetail;
use App\Model\TreatmentDetailStep;
use App\Model\Payment;
use App\Model\TreatmentHistory;
use App\Model\TreatmentImage;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait TreatmentHistoryBusinessFunction
{
   use PaymentBusinessFunction;
   use EventBusinessFunction;
    public function getTreatmentHistory($id)
    {
        $patient = Patient::where('id', $id)->first();
        if ($patient == null) {
            return [];
        }
        $treatmentHistoryList = $patient->hasTreatmentHistory() == null ?
            [] : $patient->hasTreatmentHistory()->get();

        foreach ($treatmentHistoryList as $treatmentHistory) {
            $treatmentHistoryDetailList = $treatmentHistory->hasTreatmentDetail()->get();
            foreach ($treatmentHistoryDetailList as $treatmentHistoryDetail) {
                $treatmentHistoryDetail->dentist = $treatmentHistoryDetail->belongsToStaff()->first();
                $treatmentHistoryDetail->treatment_images = $treatmentHistoryDetail->hasTreatmentImage()->get();
                $treatmentMedicines = $treatmentHistoryDetail->hasMedicinesQuantity()->get();
                foreach ($treatmentMedicines as $treatmentMedicine) {
                    $treatmentMedicine->medicine = $treatmentMedicine->belongsToMedicine()->first();
                }
                $treatmentDetailSteps = $treatmentHistoryDetail->hasTreatmentDetailStep()->get();
                foreach ($treatmentDetailSteps as $treatmentDetailStep) {
                    $treatmentDetailStep->step = $treatmentDetailStep->belongsToStep()->first();
                }
                //add property to object
                $treatmentHistoryDetail->prescriptions = $treatmentMedicines;
                $treatmentHistoryDetail->treatment_detail_steps = $treatmentDetailSteps;
            }
            $treatmentHistory->details = $treatmentHistoryDetailList;
            $treatmentHistory->treatment = $treatmentHistory->belongsToTreatment()->first();
            $treatmentHistory->patient = $patient;
            $treatmentHistory->tooth = $treatmentHistory->belongsToTooth()->first();
            $treatmentHistory->payment = $treatmentHistory->belongsToPayment()->first();
        }
        return $treatmentHistoryList;
    }

    public function getTreatmentHistoryByPatientId($id)
    {
        $patient = Patient::where('id', $id)->first();
        
        if ($patient != null) {
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

    public function saveTreatmentHistory($treatmentHistory)
    {

        DB::beginTransaction();
        try {
            $treatmentHistory->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }
    }

    public function createTreatmentProcess($idTreatment, $idPatient, $toothNumber, $price, $description)
    {
        DB::beginTransaction();
        try {
            $patient = Patient::find($idPatient);
            $phone = $patient->belongsToUser()->first()->phone;
            $payment = $this->checkPaymentIsDone($phone);
            $percentDiscountOfTreatment = $this->checkDiscount($idTreatment);
            $total_price = $price - $price * $percentDiscountOfTreatment / 100;
            if ($payment) {
                $this->updatePayment($total_price, $payment->id);
                $idPayment = $payment->id;
            } else {
                $idPayment = $this->createPayment($total_price, $phone);
            }
            $idTreatmentHistory = TreatmentHistory::create([
                'treatment_id' => $idTreatment,
                'patient_id' => $idPatient,
                'description' => $description,
                'create_date' => Carbon::now(),
                'tooth_number' => $toothNumber,
                'price' => $price,
                'total_price' => $total_price,
                'payment_id' => $idPayment,
            ])->id;
            DB::commit();

            return $idTreatmentHistory;

        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }

    }

    public function checkCurrentTreatmentHistoryForPatient($idPatient){
       return TreatmentHistory::where('patient_id', $idPatient)
            ->whereNull('finish_date')->get();
    }

    public function getListTreatmentHistory(){
        $treatmentHistoryList = TreatmentHistory::all();
        foreach ($treatmentHistoryList as $treatmentHistory){
            $treatmentHistory->patient = $treatmentHistory->belongsToPatient()->first();
            $treatmentHistory->treatment = $treatmentHistory->belongsToTreatment()->first();
        }
        return $treatmentHistoryList;
    }

    public function getTreatmentHistoryDetail($id){
        $treatmentHistory = TreatmentHistory::where('id', $id)->first();
        $treatmentHistory->patient = $treatmentHistory->belongsToPatient()->first();
        $treatmentHistory->treatment = $treatmentHistory->belongsToTreatment()->first();
        $listDetail = $treatmentHistory->hasTreatmentDetail()->get();

        foreach ($listDetail as $detail){
            $detail->staff = $detail->belongsToStaff()->first();
            $listTreatmentDetailStep = $detail->hasTreatmentDetailStep()->get();
            $result = [];
            foreach ($listTreatmentDetailStep as $treatmentDetailStep) {
                $result[] = $treatmentDetailStep->belongsToStep()->first()->name;
            }
            $detail->listStepDone = $result;
        }
        $treatmentHistory->listDetail = $listDetail;
        return $treatmentHistory;
    }
}