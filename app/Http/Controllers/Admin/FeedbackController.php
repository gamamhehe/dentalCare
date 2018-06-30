<?php

namespace App\Http\Controllers\Admin;

use App\Model\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    //
    public function create(Request $request){
        $feedback = new Feedback();
        $feedback->content = $request->content_feedback;
        $feedback->patient_id = $request->session()->get('currentPatient',null)->id;

    }
}
