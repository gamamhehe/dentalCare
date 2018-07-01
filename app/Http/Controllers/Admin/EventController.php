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
    public function createEvent(Request $request){
        $input = $request->all();
        $Event = new Event();
        $Event->name = (int) $input['name'];
        $Event->discount =(int) $input['discount'];
        $Event->treatment_id =$input['listTreatment'];
        $Event->start_date=Carbon::now();
        $Event->end_date=Carbon::now();
        $Event->staff_id=1;

        $Newsxxx = $this->createEventBusiness($Event);
        if($Newsxxx){

            return redirect()->route("admin.list.event")->withSuccess("Sự kiện đã được tạo");
        }else{
            return redirect('admin/list-Event')->withSuccess("Sự kiện chưa được tạo");
        }


    }

    public function getListEvent(Request $request){
        $listEvent = Event::all();
        return Datatables::of($listEvent)
            ->addColumn('action', function($listEvent) {
                return '<a href="editEvent/'.$listEvent->id.'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Edit</a> <a id="'.$listEvent->id.'" onclick="deleteNews(this)" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Delete</a>';
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
        $Event = Event::find($id);
        $listTreatment = Treatment::all();
        return view("admin.event.edit",['Event'=>$Event,'listTreatment'=>$listTreatment]);
    }
    public function editEvent(Request $request,$id){

        $input = $request->all();
        DB::beginTransaction();
        try{
            $Event = Event::find($id);
            $Event->name =  $input['name'];
            $Event->discount =(int) $input['discount'];
            $Event->treatment_id =(int)$input['listTreatment'];
            $Event->start_date=Carbon::now();
            $Event->end_date=Carbon::now();
            $Event->staff_id=1;
            $Event->save();
            DB::commit();
            return redirect()->route("admin.list.event")->withSuccess("Bài viết đã được chỉnh");

        }catch(\Exception $e){
            dd($e);
            DB::rollback();
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
