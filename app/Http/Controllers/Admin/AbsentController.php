<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AbsentBusinessFunction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsentController extends Controller
{
    //
    use AbsentBusinessFunction;

    public function getInforAbsent(Request $request)
    {
        $check = $this->checkExistAbsentStaff($request->staff_id, $request->date_absen);
        if ($check) {
            $this->createAbsent($request->staff_id, $request->date_absent);
            return true;
        } else
            return false;
    }

    public function showAbsentnotApprove(){

    }
}
