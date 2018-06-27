<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 27-Jun-18
 * Time: 23:10
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Feedback;
use Illuminate\Support\Facades\DB;

trait FeedbackBusinessFunction
{
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
        if($feedback!=null){
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