<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\FeedbackBusinessFunction;
use App\Model\Feedback;
use App\Model\TreatmentDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use DB;

class FeedbackController extends Controller
{
    use FeedbackBusinessFunction;

    public function loadListFeedback(Request $request)
    {
        $sessionUser = $request->session()->get('currentAdmin', null);
        $roleID = $sessionUser->hasUserHasRole()->first()->belongsToRole()->first()->id;
        return view('admin.feedback.list', ['role' => $roleID]);
    }

    public function getListFeedback(Request $request)
    {

        $feedbackList = Feedback::all();
        $Static_html = "☆";
        foreach ($feedbackList as $feedback) {
            $number_start = $feedback->number_start;
            $html_numberStart = "";
            for ($x = 1; $x <= $number_start; $x++) {
                $html_numberStart = $html_numberStart . "" . $Static_html;
            }
            $feedback->demo = $html_numberStart;

        }
        $sessionUser = $request->session()->get('currentAdmin', null);
        $roleID = $sessionUser->hasUserHasRole()->first()->belongsToRole()->first()->id;
        if ($roleID == 1) {
            return Datatables::of($feedbackList)
                ->addColumn('action', function ($feedbackList) {
                    return '<a href="detailsFeedback/' . $feedbackList->id . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>View details</a> <a id="' . $feedbackList->id . '" onclick="deleteFeedback(this)" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Delete</a>';
                })->make(true);
        } else {
            return Datatables::of($feedbackList)
                ->addColumn('action', function ($feedbackList) {
                    return '<a href="viewsFeedback/' . $feedbackList->id . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>View</a> ';
                })->make(true);
        }


    }

    public function getDetailsFeedback(Request $request, $id)
    {
        $Feedback = Feedback::find($id);
        $contet = $Feedback->content;
        $Feedback->content = trim($contet);
        $Feedback->treatment_detail_id = $Feedback->belongsToTreatmentDetail()->first()->belongsToStaff()->first();

        return view('admin.feedback.details', ['Feedback' => $Feedback]);
    }


    public function getViewsFeedback(Request $request, $id)
    {

//        $Feedback = $this->getDetailsFeedback($id);
        $Feedback = Feedback::find($id);
//        $Feedback->treatment_detail_id = $Feedback->belongsToTreatmentDetail()->first();
        $Feedback->treatment_detail_id = $Feedback->belongsToTreatmentDetail()->first()->belongsToStaff()->first();
//        dd($Feedback->treatment_detail_id->name);
        return view('admin.feedback.views', ['Feedback' => $Feedback]);
    }

    public function editFeedback(Request $request, $id)
    {
        $input = $request->all();
        $content = $request->input('content');

        $Feedback = Feedback::find($id);
        $Feedback->content = $content;
        $Feedback->save();
        return redirect('admin/list-Feedback');
    }

    public function deleteFeedback(Request $request, $id){

        $Feedback = $this->deleteFeedbackBusiness($id);

        if ($Feedback) {
            return redirect('admin/list-Feedback')->withSuccess("Bài đánh giá đã được xóa");
        } else {
            return redirect('admin/list-Feedback')->withSuccess("Bài đánh giá chưa được xóa");
        }


    }
}
