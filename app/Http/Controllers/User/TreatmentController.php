<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TreatmentController extends Controller
{
    use TreatmentBusinessFunction;
    //
    public function showTreatmentHistory(Request $request){
        return $this->getTreatmentHistory('1');
    }
}
