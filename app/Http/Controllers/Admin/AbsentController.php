<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AbsentBusinessFunction;
use App\Model\Absent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsentController extends Controller
{
    //
    use AbsentBusinessFunction;

    public function getInfoAbsent(Request $request)
    {
        $check = $this->checkExistAbsentStaff($request->staff_id, $request->date_absen);
        if ($check) {
            $this->createAbsent($request->staff_id, $request->date_absent);
            return true;
        } else
            return false;
    }

    public function showAbsentnotApprove(){
        $result = Absent::where('staff_approve_id', 0)->get();
        return $result;
    }

    public function approveAbsent(Request $request){
        $listId = $request->Absent;
        $idCurrentAdmin = $request->session()->get('currentAdmin',null)->belongToStaff()->first()->id;
        foreach ($listId as $id){
            $absent = Absent::find($id);
            $absent->staff_approve_id = $idCurrentAdmin;
            $absent->save();
        }
        return view('admin.absent.list');
    }
}
