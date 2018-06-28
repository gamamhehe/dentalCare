<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Absent;
use App\Model\Feedback;
use App\Model\Role;
use Illuminate\Http\Request;
use DB;

trait FeedbackBusinessFunction
{
    public function getDetailsFeedback(Request $request,$id){

        $feedback = Feedback::where('id', $id)->get();
        $feedback->treatment_detail_id = $feedback->belongsToTreatmentDetail()->first()->detist_id;
        dd($feedback);
    }
    public function deleteFeedbackBusiness($id){
        DB::beginTransaction();
        try{
            $feedback = Feedback::where('id', $id)->first();
            $feedback->delete();
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollback();
            return false;

        }
    }
}