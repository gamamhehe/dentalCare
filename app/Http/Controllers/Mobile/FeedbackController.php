<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 27-Jun-18
 * Time: 23:06
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\FeedbackBusinessFunction;
use App\Http\Controllers\Controller;
use App\Model\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    use FeedbackBusinessFunction;
    public function create(Request $request)
    {
        $content = $request->input("content");
        $patientId = $request->input("patient_id");
        $treatmentDetailId = $request->input("treatment_detail_id");
        $dateFeedback = $request->input("date_feedback");
<<<<<<< HEAD
        $numStar = $request->input("num_of_star");
=======
        $numStar = $request->input("num_of_stars");
>>>>>>> UAT

        $feedbackBoolean = $this->checkTreatmentFeedbackExists($treatmentDetailId);
        if(!$feedbackBoolean){
            $feedback = new Feedback();
            $feedback->content = $content;
            $feedback->patient_id = $patientId;
            $feedback->date_feedback = $dateFeedback;
            $feedback->num_of_stars = $numStar;
            $feedback->treatment_detail_id = $treatmentDetailId;
            $result = $this->saveFeedback($feedback);
            if($result){
                return response()->json("Gửi đánh giá thành công",200);
            }else{
                $error = new \stdClass();
                $error->error = "Không thể tạo đánh giá";
                $error->exception = null;
                return response()->json($error,200);
            }
        }else{
            $feedback = $this->getFeedbackByTreatmentId($treatmentDetailId);

            $feedback->content = $content;
            $feedback->patient_id = $patientId;
            $feedback->date_feedback = $dateFeedback;
            $feedback->num_of_stars = $numStar;
            $feedback->treatment_detail_id = $treatmentDetailId;
            $result = $this->saveFeedback($feedback);
            if($result){
                return response()->json("Gửi đánh giá thành công",200);
            }else{
                $error = new \stdClass();
                $error->error = "Không thể tạo đánh giá dịch vụ";
                $error->exception = null;
                return response()->json($error,200);
            }
        }


    }

}