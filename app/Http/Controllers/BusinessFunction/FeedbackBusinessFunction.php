<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 * <<<<<<< HEAD
 * =======
 * User: Luc
 * Date: 27-Jun-18
 * Time: 23:10
 * >>>>>>> UAT
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Absent;
use App\Model\Feedback;
use App\Model\Role;
use Illuminate\Http\Request;
use DB;

trait FeedbackBusinessFunction
{
    public function getDetailsFeedback(Request $request, $id)
    {

        $feedback = Feedback::where('id', $id)->get();
        $feedback->treatment_detail_id = $feedback->belongsToTreatmentDetail()->first()->detist_id;
        dd($feedback);
    }

    public function deleteFeedbackBusiness($id)
    {
        DB::beginTransaction();
        try {
            $feedback = Feedback::where('id', $id)->first();
            $feedback->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }
    }

    public function saveFeedback($feedback)
    {
        DB::beginTransaction();
        try {
            $feedback->save();
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollback();
            throw new \Exception($exception->getMessage());
        }
    }

    public function checkTreatmentFeedbackExists($treatmentDetailId)
    {
        $feedback = Feedback::where('treatment_detail_id', $treatmentDetailId)->first();
        if ($feedback != null) {
            return true;
        }
        return false;
    }

//    1 feedback <-> 1 treatment id
    public function getFeedbackByTreatmentId($treatmentDetailId)
    {
        $feedback = Feedback::where('treatment_detail_id', $treatmentDetailId)->first();
        return $feedback;
    }
}