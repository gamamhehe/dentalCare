<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/14/2018
 * Time: 8:11 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Helpers\AppConst;
use App\Helpers\Utilities;
use App\Http\Controllers\Blockchain\BlockchainController;
use App\Http\Controllers\Blockchain\QueueController;
use App\Model\Patient;
use App\Model\TreatmentDetail;
use App\Model\TreatmentDetailStep;
use App\Model\Payment;
use App\Model\TreatmentHistory;
use App\Model\TreatmentImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use File;

trait TreatmentHistoryBusinessFunction
{
    use PaymentBusinessFunction;
    use EventBusinessFunction;
    use BlockchainBusinessFunction;

    public function encrypt($data, $pubKey)
    {
        if (openssl_public_encrypt($data, $encrypted, $pubKey)) {
            $data = base64_encode($encrypted);
        } else {
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');
        }
        return $data;
    }

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
            $treatment = $treatmentHistory->belongsToTreatment()->first();
            if ($treatment != null) {
                $treatment->treatment_steps = $treatment->hasTreatmentStep()->get();
                foreach ($treatment->treatment_steps as $step) {
                    $step->name = $step->belongsToStep()->first()->name;
                }
            }
            $treatmentHistory->treatment = $treatment;
            $treatmentHistory->patient = $patient;
            $treatmentHistory->tooth = $treatmentHistory->belongsToTooth()->first();
            $treatmentHistory->payment = $treatmentHistory->belongsToPayment()->first();
            $symptoms = [];
            $tmHistorySymptoms = $treatmentHistory->hasTreatmentSymptom()->get();
            foreach ($tmHistorySymptoms as $tmSymptom) {
                $symptoms[] = $tmSymptom->belongsToSymptom()->first();
            }
            $treatmentHistory->symptoms = $symptoms;
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

    public function createTreatmentHistory($treatmentHistory, $detailNote, $detailStepIds, $medicines, $symptoms, $images)
    {

        DB::beginTransaction();
        try {
            $tmHistoryId = $this->createTreatmentProcess(
                $treatmentHistory->treatment_id,
                $treatmentHistory->patient_id,
                $treatmentHistory->tooth_number,
                $treatmentHistory->price,
                $treatmentHistory->description);

            Utilities::logInfo("tmHistoryId save id: " . $tmHistoryId);
            $tmDetail = new TreatmentDetail();
            $tmDetail->treatment_history_id = $tmHistoryId;
            $tmDetail->staff_id = $treatmentHistory->staff_id;
            $tmDetail->note = $detailNote;
            $tmDetail->created_date = Carbon::now();
            $tmDetail->save();
            Utilities::logInfo("tmDetail save");
            $tmDetailId = $tmDetail->id;
            if ($detailStepIds != null) {
                foreach ($detailStepIds as $stepId) {
                    $tmDetailSteps = new TreatmentDetailStep();
                    $tmDetailSteps->treatment_detail_id = $tmDetailId;
                    $tmDetailSteps->step_id = $stepId;
                    $tmDetailSteps->save();
                }
            }
            Utilities::logInfo("detailStepIds save");
            if ($medicines != null) {
                foreach ($medicines as $medicine) {
                    $medicine->treatment_detail_id = $tmDetailId;
                    $medicine->save();
                }
            }
            if ($symptoms != null) {
                foreach ($symptoms as $symptom) {
                    $symptom->treatment_history_id = $tmHistoryId;
                    $symptom->save();
                }
            }
            Utilities::logInfo("tmDetail save");
            if ($images != null) {
                foreach ($images as $image) {
                    $timestmp = (new \DateTime())->getTimestamp();
                    $path = Utilities::saveFile($image, AppConst::TREATMENT_HISTORY_PATH, $timestmp);
                    $treatmentImage = new TreatmentImage();
                    $treatmentImage->treatment_detail_id = $tmDetailId;
                    $treatmentImage->image_link = $path;
                    $treatmentImage->created_date = Carbon::now();
                    $treatmentImage->save();
                }
            }
            Utilities::logInfo("images save");

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
//            Log::info("Error: " . $e->getMessage() . 'File: ' . $e->getFile() . ' Line:' . $e->getLine().$e->getTraceAsString());
            throw new \Exception($e->getMessage());
        }
    }

    public function searchTreatmentHistory($searchValue){
        $listPatient = Patient::where('phone', 'like', $searchValue . '%')
            ->orWhere('name', 'like', '%' . $searchValue . '%')
            ->pluck('id');
        return TreatmentHistory::whereIn('patient_id', $listPatient)->get();
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

                $this->updatePayment($total_price, $payment->id, $idTreatment);
                $idPayment = $payment->id;
                $queueController = new QueueController();
                // $blockchainController = new BlockchainController();
                // $queueController->runJobQueue($blockchainController->EncryptUpdatePayment($idPayment, $idTreatment, $total_price, $payment->total_price));
            } else {

                $idPayment = $this->createPayment($total_price, $phone);
                $queueController = new QueueController();
                // $blockchainController = new BlockchainController();
                // $queueController->runJobQueue($blockchainController->EncryptCreatePayment($idPayment));

            }
            if ($description == null) {
                $description = "";
            }
            $idTreatmentHistory = TreatmentHistory::create([
                'treatment_id' => $idTreatment,
                'patient_id' => $idPatient,
                'description' => $description,
                'created_date' => Carbon::now(),
                'tooth_number' => $toothNumber,
                'price' => $price,
                'total_price' => $total_price,
                'payment_id' => $idPayment,
            ])->id;
            DB::commit();

            return $idTreatmentHistory;

        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());

        }

    }

    public function checkCurrentTreatmentHistoryForPatient($idPatient)
    {
        return TreatmentHistory::where('patient_id', $idPatient)
            ->whereNull('finish_date')->get();
    }

    public function getListTreatmentHistory()
    {
        $treatmentHistoryList = TreatmentHistory::all();
        foreach ($treatmentHistoryList as $treatmentHistory) {
            $treatmentHistory->patient = $treatmentHistory->belongsToPatient()->first();
            $treatmentHistory->treatment = $treatmentHistory->belongsToTreatment()->first();
        }
        return $treatmentHistoryList;
    }

    public function getTreatmentHistoryDetail($id)
    {
        $treatmentHistory = TreatmentHistory::where('id', $id)->first();
        $treatmentHistory->patient = $treatmentHistory->belongsToPatient()->first();
        $treatmentHistory->treatment = $treatmentHistory->belongsToTreatment()->first();
        $listDetail = $treatmentHistory->hasTreatmentDetail()->get();

        foreach ($listDetail as $detail) {
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

    public function getTreatmentHistoryById($id)
    {
        return (TreatmentHistory::where('id', $id)->first());
    }


    public function getListTmDetailByDate($tmHistoryId, $dateStr)
    {
        $tmDetails = TreatmentDetail::whereDate('created_date', $dateStr)
            ->where('treatment_history_id', $tmHistoryId)
            ->get();
        return $tmDetails;
    }

    public function getTreatmentReportByDentist($dentistId, $monthInNumber, $yearInNumber)
    {
        $data = DB::select(DB::raw("
                      SELECT count(*) as num, subquery.treatment_id, subquery.treatment_name  FROM (
                      SELECT  td.staff_id AS staff_id,  tm.id AS treatment_id , tm.name AS treatment_name FROM tbl_treatment_histories as th
                      JOIN tbl_treatment_details as td ON th.id = td.treatment_history_id
                      JOIN tbl_treatments as tm ON tm.id = th.treatment_id
                      WHERE MONTH(th.created_date) = :month  AND YEAR(th.created_date) = :year AND td.staff_id = :staff_id 
                    ) AS subquery 
                        GROUP BY subquery.treatment_id, subquery.treatment_name"),
            array(
                'month' => $monthInNumber,
                'year' => $yearInNumber,
                'staff_id' => $dentistId
            ));
        return $data;
//            ->select('',);

    }

    public function getTreatmentReportByReceptionist($monthInNumber, $yearInNumber)
    {
        $data = DB::select(DB::raw("
                      SELECT count(*) as num, subquery.treatment_id, subquery.treatment_name  FROM (
                      SELECT  tm.id AS treatment_id , tm.name AS treatment_name FROM tbl_treatment_histories as th
                      JOIN tbl_treatments as tm ON tm.id = th.treatment_id
                      WHERE MONTH(th.created_date) = :month  AND YEAR(th.created_date) = :year  
                    ) AS subquery 
                        GROUP BY subquery.treatment_id, subquery.treatment_name"),
            array(
                'month' => $monthInNumber,
                'year' => $yearInNumber
            ));
        return $data;
//            ->select('',);

    }

    public function updateTreatmentHistoryDone($id)
    {

        $date = Carbon::now();
        TreatmentHistory::where('id', $id)->update(['finish_date' => $date]);
        return $id;


    }
}