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
    //admin
    public function delete(Request $request, $id)
    {
        if ($this->deleteFeedback($id)) {
            return redirect('admin/list-feedback')->withSuccess("Bài đánh giá đã được xóa");
        } else {
            return redirect('admin/list-feedback')->withSuccess("Bài đánh giá chưa được xóa");
        }
    }
    public function loadListFeedback(Request $request)
    {
        $sessionUser = $request->session()->get('currentAdmin', null);
        $roleID = $sessionUser->hasUserHasRole()->first()->belongsToRole()->first()->id;
        return view('admin.Feedback.list', ['role' => $roleID]);
    }
    public function getListFeedback(Request $request)
    {

        $feedbackList = $this->getAllFeedback();
        $Static_html = "<i class=\"fa fa-star text-yellow\"></i>";
        foreach ($feedbackList as $feedback) {
            $number_start = $feedback->num_of_stars;
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
                    return '<a href="details-feedback/' . $feedbackList->id . '" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Xem chi tiết</a> <a id="' . $feedbackList->id . '" onclick="deleteFeedback(this)" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Xóa</a>';
                })->rawColumns(['demo','action'])->make(true);
        } else {
            return Datatables::of($feedbackList)
                ->addColumn('action', function ($feedbackList) {
                    return '<a href="views-feedback/' . $feedbackList->id . '" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Xem chi tiết</a> ';
                })->rawColumns(['demo','action'])->make(true);
        }


    }
    public function getDetailsFeedback($id)
    {
        $Feedback = $this->getFeedbackID($id);
        $contet = $Feedback->content;
        $Feedback->content = trim($contet); 
        $Feedback->treatment_detail = $Feedback->belongsToTreatmentDetail()->first()->belongsToStaff()->first();
        return view('admin.feedback.details', ['Feedback' => $Feedback]);
    }
    public function getViewsFeedback(Request $request, $id)
    {
        $Feedback = $this->getFeedbackID($id);
        $Feedback->treatment_detail_id = $Feedback->belongsToTreatmentDetail()->first()->belongsToStaff()->first();
        return view('admin.feedback.views', ['Feedback' => $Feedback]);
    }
    //user
    public function edit(Request $request, $id)
    {
        if( $this->editFeedback($request->all(), $id)){
            return redirect()->route("admin.list.feedback")->withSuccess("Feedback đã được chỉnh");

        }else{
            return redirect()->back()->withSuccess("Bài viết chưa được chỉnh");
        }
    }


    public function create(Request $request){
        $feedback = new Feedback();
        $feedback->content = $request->content_feedback;
        $feedback->patient_id = $request->session()->get('currentPatient',null)->id;

    }
}
