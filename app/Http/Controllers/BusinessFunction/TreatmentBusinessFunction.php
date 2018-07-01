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

trait TreatmentBusinessFunction
{
    use PaymentBusinessFunction;
    use EventBusinessFunction;

    public function getTreatmentHistory($id)
    {
        $listResult = [];
        $patient = Patient::where('id', $id)->first();
        $treatmentHistoryList = $patient->hasTreatmentHistory()->get();

//        $patient = Patient::where('id',$id)->first();
//            $treatmentHistoryList = $patient->hasTreatmentHistory()->get();
//
//            foreach ($treatmentHistoryList as $treatmentHistory) {
//                $treatmentHistoryDetailList = $treatmentHistory->hasTreatmentDetail()->get();
//
//                foreach ($treatmentHistoryDetailList as $treatmentHistoryDetail){
//
//                    $treatmentHistoryDetail->dentist_id = $treatmentHistoryDetail->belongsToStaff()->first();
//                }
//                foreach ($treatmentHistoryDetailList as $treatmentHistoryDetail){
//                    $treatmentHistoryDetail->step = $treatmentHistoryDetail->hasTreatmentDetailStep()->first()->belongsToStep()->first();
//                }


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

//
//                foreach ($treatmentHistoryDetailList as $treatmentHistoryDetail){
//                    $treatmentHistoryDetail->step = $treatmentHistoryDetail->hasTreatmentDetailStep()->get();
//
//                }

//        }
//        dd($treatmentHistoryList);
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

    public function createTreatmentDetail($idTreatmentHistory, $note, $dentist_id)
    {
        DB::beginTransaction();
        try {
            $idTreatmentDetail = TreatmentDetail::create([
                'treatment_history_id' => $idTreatmentHistory,
                'dentist_id' => $dentist_id,
                'note' => $note,
                'create_date' => Carbon::now()
            ])->id;
            DB::commit();
            return $idTreatmentDetail;
        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }
    }

    public function createTreatmentDetailStep($listStep, $idTreatmentDetail, $description)
    {
        DB::beginTransaction();
        try {
            foreach ($listStep as $step) {
                TreatmentDetailStep::create([
                    'treatment_detail_id' => $idTreatmentDetail,
                    'treatment_step_id' => $step->id,
                    'description' => $description,
                ]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }
    }

    public function createTreatmentImage($imageLink, $idTreatmentDetail)
    {
        DB::beginTransaction();
        try {
            TreatmentImage::create([
                'treatment_detail_id' => $idTreatmentDetail,
                'image_link' => $imageLink,
                'create_date' => Carbon::now(),
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }
    }

    public function showTreatmentStepForTreatment($idTreatment)
    {
        $listTreatmentStep = Treatment::find($idTreatment)->hasTreatmentStep()->get();
        dd($listTreatmentStep);
        $result = [];
        foreach ($listTreatmentStep as $treatmentStep) {
            $result[] = $treatmentStep->belongsToStep()->first();
        }
        return $result;
    }

    public function showTreatmentDetailStepDone($idTreatmentHistory)
    {
        $treatmentHistory = TreatmentHistory::find($idTreatmentHistory);
        $listTreatmentDetail = $treatmentHistory->hasTreatmentDetail()->get();
        $result = [];
        foreach ($listTreatmentDetail as $treatmentDetail) {
            $listTreatmentDetailStep = $treatmentDetail->hasTreatmentDetailStep()->get();
            foreach ($listTreatmentDetailStep as $treatmentDetailStep) {
                $result[] = $treatmentDetailStep->treatment_step_id;
            }
        }
        return $result;
    }
}