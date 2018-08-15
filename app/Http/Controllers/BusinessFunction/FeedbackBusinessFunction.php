<?php
/**
 * Created by PhpStorm.
<<<<<<< HEAD
 * User: Luc
 * Date: 27-Jun-18
 * Time: 23:10
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 * User: Luc
 * Date: 27-Jun-18
 * Time: 23:10
=======
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 * <<<<<<< HEAD
 * =======
 * User: Luc
 * Date: 27-Jun-18
 * Time: 23:10
 * >>>>>>> UAT
>>>>>>> UAT
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Absent;
use App\Model\Feedback;
use App\Model\Role;
use App\Model\TreatmentDetail;
use Illuminate\Http\Request;
use DB;

trait FeedbackBusinessFunction
{
    public function getDetailsFeedback(Request $request, $id)
    {
        $feedback = Feedback::where('id', $id)->get();
        $feedback->treatment_detail_id = $feedback->belongsToTreatmentDetail()->first()->detist_id;
    }
    public function getFeedbackID($id){
        $Feedback = Feedback::find($id);
        return $Feedback;
    }
    public function getAllFeedback(){
        $Feedback = Feedback::all();
        return $Feedback;
    }
    public function deleteFeedback($id)
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
    public function editFeedback($input,$id){
        DB::beginTransaction();
        try{
            $content = $input['content'];
            $Feedback = $this->getFeedbackID($id);
            $Feedback->content = $content;
            $Feedback->save();
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollback();
            return false;
        }
    }
    public function getNumberStart($id){
        $treatmentDetails = TreatmentDetail::where('staff_id',$id)->get();

        $treatFeed = [];
        $numberStart = 0;
        foreach ($treatmentDetails as $treatmentDetail) {
            $treatmentDetail->xxx = $treatmentDetail->hasFeedback()->first();
            if( $treatmentDetail->xxx != null){
                $treatFeed[] = $treatmentDetail;
                $numberStart = $numberStart +  $treatmentDetail->xxx->num_of_stars;
            }
        }
        $totalFeedback = count($treatFeed);
        if($totalFeedback == 0){
           $finalStar =0;
            return $finalStar;
        }else{
            $finalStar = ($numberStart/($totalFeedback*5))*10;
            return $finalStar;
        }
        
    }

}