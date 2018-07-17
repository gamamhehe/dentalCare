<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\EventBusinessFunction;
use App\Model\News;
use App\Model\Treatment;
use App\Model\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\Datatables\Facades\Datatables;
use DB;
class EventController extends Controller
{
    use EventBusinessFunction;
    public function create(Request $request){




        if($this->createEvent($request->all())){

            return redirect()->route("admin.list.event")->withSuccess("Sự kiện đã được tạo");
        }else{
            return redirect('admin/list-Event')->withSuccess("Sự kiện chưa được tạo");
        }
    }

    public function getListEvent(Request $request){
        $listEvent = $this->getAllEvent();
        return Datatables::of($listEvent)
            ->addColumn('action', function($listEvent) {
                return '<a href="editEvent/'.$listEvent->id.'" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Chỉnh sửa</a> <a id="'.$listEvent->id.'" onclick="deleteNews(this)" class="btn btn-success btn-sm "><i class="glyphicon glyphicon-edit"></i>Xóa</a>';
            })->make(true);
    }
    public function loadcreateEvent(Request $request){
        $listTreatment = Treatment::all();
        return view('admin.event.create',['listTreatment'=>$listTreatment]);
    }
    public function loadListEvent(Request $request){
        return view('admin.event.list');
    }
    public function loadEditEvent($id){
        $Event = $this->getEventByID($id);
        $listTreatment = Treatment::all();
        return view("admin.event.edit",['Event'=>$Event,'listTreatment'=>$listTreatment]);
    }
    public function edit(Request $request,$id){
        if($this->editEvent($request->all(),$id)){
            return redirect()->route("admin.list.event")->withSuccess("Bài viết đã được chỉnh");
        }else{
            return redirect()->back()->withSuccess("Bài viết chưa được chỉnh");
        }
    }
    public function deleteEvent(Request $request,$id){
        $EventBoolean = $this->deleteEventBusiness($id);
        if($EventBoolean){
            return redirect('admin/list-Event')->withSuccess("Bài viết đã được xóa");
        }else{
            return redirect('admin/list-Event')->withSuccess("Bài viết chưa được xóa");
        }
    }

}
