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
    public function loadcreate(){
        return view ("admin.Absent.create");
    }
    public function create(Request $request)
    {
        $check = $this->checkExistAbsentStaff($request->staff_id, $request->start_date, $request->end_date);
        if ($check) {
            $this->createAbsent($request->staff_id, $request->start_date, $request->end_date, $request->reason);
            return true;
        } else
            return false;
    }

    public function showListOfStaff($id)
    {
        return $this->showListAbsentOfStaff($id);
    }

    public function showNotApprove()
    {
        $result = $this->getListAbsentNotApprove();
        return view('admin.absent.list', ['listAbsent' => $result]);
    }

    public function showList()
    {
        $result = $this->getListAbsent();
        return view('admin.absent.list', ['listAbsent' => $result]);
    }

    public function approve(Request $request)
    {
        $id = $request->Absent;
        $idCurrentAdmin = $request->session()->get('currentAdmin', null)->belongToStaff()->first()->id;
        $this->approveAbsent($id, $idCurrentAdmin, $request->message);
        return route('admin.list.absent');
    }
}
