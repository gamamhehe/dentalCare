<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AbsentBusinessFunction;
use App\Http\Controllers\BusinessFunction\StaffBusinessFunction;
use App\Model\Absent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\RequestAbsent;
use Carbon\Carbon;
use DB;
use Month;
use Yajra\Datatables\Facades\Datatables;
use App\Helpers\AppConst;
use App\Jobs\SendSmsJob;
class AbsentController extends Controller
{
    //
    use AbsentBusinessFunction;
    use StaffBusinessFunction;
    public function changeView(Request $request){
        $role = $request->session()->get("roleAdmin");
        if($role == 1){
            return redirect()->route("admin.Manage.Absent");
        }
        return redirect()->route("create.Absent");
    }
    public function loadcreate(Request $request){

        return view ("admin.Absent.create");
    }
    
    public function create(Request $request)
    {
        $staff_id = $request->session()->get("currentAdmin")->belongToStaff()->first();
        $check = $this->checkAbsentForStaffWasApprove($staff_id, $request->start_date, $request->end_date);
        if ($check) {//ngày nghỉ hợp lệ
        $this->createAbsent($staff_id->id, (new Carbon($request->start_date))->format('Y-m-d H:i:s'), (new Carbon($request->end_date))->format('Y-m-d H:i:s'), $request->reason);

             return redirect('/admin/create-absent')->withSuccess("Đơn xin nghỉ được chấp nhận");
        } else// do đã
            return redirect()->back()->withError("Đơn xin nghỉ chưa được chấp nhận");
    }

    public function showListOfStaff($id)
    {
        return $this->showListAbsentOfStaff($id);
    }
    public function showListAbsentDatatable(Request $request){
        $staff_id = $request->session()->get("currentAdmin")->belongToStaff()->first(); 
        $listAbsent = $this->getListAbsentByStaff($staff_id->id);
        foreach ($listAbsent as $key) {
            if($key->status != null){
                $key->action = '<a class="btn btn-success btn-sm" disabled><i class="glyphicon glyphicon-edit"></i>Đã chấp nhận</a>';
            }else{
                $key->action = ' <a id="' . $key->id . '" onclick="deleteNews(this)" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-edit"></i>Xóa</a>';
            }

        }
          return Datatables::of($listAbsent)->make(true);

         
    }
    public function showNotApprove()
    {
        $result = $this->getListAbsentNotApprove();
        return view('admin.Absent.list', ['listAbsent' => $result]);
    }

    public function showList()
    {
        $result = $this->getListAbsent();
        return view('admin.Absent.list', ['listAbsent' => $result]);
    }

    public function approve(Request $request)
    {
        
        $id = $request->Absent;
        $absentCurrent = $this->getAbsentById($id);
        $idCurrentAdmin = $request->session()->get('currentAdmin', null)->belongToStaff()->first();
        $checkBeforeApprove = $this->checkAbsentForStaffWasApprove($idCurrentAdmin,$absentCurrent->start_date,$absentCurrent->end_date);
        if ($checkBeforeApprove) {//ngày nghỉ hợp lệ
             $result = $this->approveAbsent($id, $idCurrentAdmin->id, $request->message);
            if($result){
                $smsMessage = AppConst::getSmsMSGForAbsent( $idCurrentAdmin->name, $absentCurrent->start_date,$absentCurrent->end_date);
                $this->dispatch(new SendSmsJob($idCurrentAdmin->phone, $smsMessage));
                return 1;
            }else{
                return "Ngày nghỉ đã chấp nhận từ trước!";
            }    
        } else// do đã
            return "Ngày nghỉ đã chấp nhận từ trước!";
        //      
    }
    public function loadView(Request $request){
        $listStaff= $this->getListStaff();
        $listDate = [];
        $x = [];
        $string ="";
        for($i = 2018; $i <= 2020;$i ++){
            for($y = 1; $y<= 12;$y++){
                if($y<10){
                    $string ="Thang "."0".$y." Năm ".$i;
                }else{
                    $string ="Thang ".$y." Năm ".$i;
                }
                $object = (object) [
                    'string' => $string ,
                    'value' => $y."-".$i,
                ];
                     
                    $listDate[]=$object;
                }
        }
        
        return view('admin.Absent.list',['staffs'=>$listStaff,'dates'=>$listDate]);
    }
    public function deleteAbsent(Request $request){
        if ($this->deleteAbsentById($request->id)) {
            return redirect('admin/create-absent')->withSuccess("Thuốc đã được xóa");
        } else {
            return redirect('admin/create-absent')->withError("Thuốc chưa được xóa");
        }
    }
    public function showListAbsentDatatableAdmin(Request $request){
        $listAbsent =$this->getListAbsentByAdmin();
        $currentAdmin= session()->get("currentAdmin")->belongToStaff()->first();
        
         foreach ($listAbsent as $key) {
            if($key->status != null){
                $key->action = '<a class="btn btn-success btn-sm" disabled><i class="glyphicon glyphicon-edit"></i>Đã chấp nhận</a>';
            }else{
                $key->action = ' <a id="' . $key->id . '" class="btn btn-warning btn-sm approve-Absent" data-id="' . $key->id . '" data-admin ="' . $currentAdmin->name . '"  data-start="'.$key->start_date.'" data-end="'.$key->end_date.'" data-name="'.$key->nameStaff.'"><i class="glyphicon glyphicon-edit"></i>Chấp Nhận</a> <a data-id="' . $key->id . '"class="btn btn-warning btn-delete btn-sm"><i class="glyphicon glyphicon-edit"></i>Xóa</a>';
            }

        }
          return Datatables::of($listAbsent)->make(true);

    }
    public function count(Request $request){
        $idCurrentAdmin = $request->session()->get('currentAdmin', null)->belongToStaff()->first()->id;
        $total = count($this->getListAbsentByStaffNotApprove($idCurrentAdmin));
        return $total;
    }
    public function searchAbsent(Request $request){

        $status = $request['statusApp'];//never null
        $dateTime = $request['date'];
        $staffId = $request['staff'];
        if($dateTime != null){
            $listAbsent = RequestAbsent::where(Month(start_date),8)->get();
        }else{
            dd("L");
        }
        if($dateTime == null && $staffId == null && $status !=null){
             $listAbsent = RequestAbsent::where('is_deleted',$status)->get();
        }else if($dateTime == null && $staffId !=null){
            $listAbsent = RequestAbsent::where('is_deleted',$status)
                                        ->where('staff_id',$staffId)
                                        ->get();
        }else if($dateTime !=null && $staffId == null){
            $listAbsent = RequestAbsent::where('is_deleted',$status)
                                        ->where('start_date','<',$dateTime)
                                        ->get();
        }else{
            dd("FUll");
        }
        dd($listAbsent);
       
    }
}
