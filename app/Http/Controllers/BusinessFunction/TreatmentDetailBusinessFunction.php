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
use App\Model\TreatmentDetail;
use App\Model\TreatmentDetailStep;
use App\Model\TreatmentHistory;
use App\Model\TreatmentImage;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
trait TreatmentDetailBusinessFunction
{

    public function getAllTreatmentDetail()
    {
        return TreatmentDetail::all();
    }

    public function getTreatmentDetailById($id)
    {
        return TreatmentDetail::where('id', $id)->first();
    }

    public function createTreatmentDetail($idTreatmentHistory, $note, $dentist_id)
    {
        if ($note == null) {
            $note = "&nsbp";
        }
        DB::beginTransaction();
        try {
            $idTreatmentDetail = TreatmentDetail::create([
                'treatment_history_id' => $idTreatmentHistory,
                'staff_id' => $dentist_id,
                'note' => $note,
                'created_date' => Carbon::now()
            ])->id;
            DB::commit();
            return $idTreatmentDetail;
        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }
    }

    public function createTreatmentDetailWithModel($tmHistoryId, $staffId, $detailNote, $detailStepIds, $medicines, $images)
    {
        DB::beginTransaction();
        try {
            Utilities::logDebug("tmHistoryId save id: " . $tmHistoryId);
            $tmDetail = new TreatmentDetail();
            $tmDetail->treatment_history_id = $tmHistoryId;
            $tmDetail->staff_id = $staffId;
            $tmDetail->note = $detailNote;
            $tmDetail->created_date = Carbon::now();
            $tmDetail->save();
            Utilities::logDebug("tmDetail save");
            $tmDetailId = $tmDetail->id;
            if ($detailStepIds != null) {
                foreach ($detailStepIds as $stepId) {
                    $tmDetailSteps = new TreatmentDetailStep();
                    $tmDetailSteps->treatment_detail_id = $tmDetailId;
                    $tmDetailSteps->step_id = $stepId;
                    $tmDetailSteps->save();
                }
            }
            Utilities::logDebug("detailStepIds save");
            if ($medicines != null) {
                foreach ($medicines as $medicine) {
                    $medicine->treatment_detail_id = $tmDetailId;
                    $medicine->save();
                }
            }
            Utilities::logDebug("tmDetail save");
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
            Utilities::logDebug("images save");
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function createTreatmentDetailStep($listStep, $idTreatmentDetail)
    {
        DB::beginTransaction();
        try {
            foreach ($listStep as $step) {
                TreatmentDetailStep::create([
                    'treatment_detail_id' => $idTreatmentDetail,
                    'step_id' => $step,
                ]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }
    }

    public function getTreatmentDetailStep($idTreatmentDetail)
    {
        $listStep = TreatmentDetailStep::where('treatment_detail_id', $idTreatmentDetail)->get();
        foreach ($listStep as $key) {
            $key->stepName = $key->belongsToStep()->first();
        }
        return $listStep;
    }

    public function showTreatmentDetailStepDone($idTreatmentHistory)
    {
        $treatmentHistory = TreatmentHistory::find($idTreatmentHistory);
        $listTreatmentDetail = $treatmentHistory->hasTreatmentDetail()->get();
        $result = [];
        foreach ($listTreatmentDetail as $treatmentDetail) {
            $listTreatmentDetailStep = $treatmentDetail->hasTreatmentDetailStep()->get();

            foreach ($listTreatmentDetailStep as $treatmentDetailStep) {
                $result[] = $treatmentDetailStep->belongsToStep()->first();
            }
        }
        return $result;
    }

    public function viewTreatmentDetail($treatmentDetailId)
    {
        $treatmentDetail = TreatmentDetail::find($treatmentDetailId);
        return $treatmentDetail;

    }

    public function checkDoneTreatmentHistory($idTreatmnet, $idTreatmentHistory)
    {

    }

    public function getTreatmentDetail($idTreatmentHistory)
    {
        $treatmentDetail = TreatmentDetail::where('treatment_history_id', $idTreatmentHistory)->first();
        return $treatmentDetail;
    }
}