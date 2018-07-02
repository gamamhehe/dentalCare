<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\MedicineBusinessFunction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Medicine;
use DB;
use Yajra\Datatables\Facades\Datatables;

class MedicineController extends Controller
{
    use MedicineBusinessFunction;

    public function createNews(Request $request)
    {
        if($this->createMedicine($request->all())){
            return redirect()->route("admin.list.medicines")->withSuccess("Sự kiện đã được tạo");
        } else {
            return redirect('admin/list-Medicines')->withSuccess("Sự kiện chưa được tạo");
        }
    }

    public function getList()
    {
        $listEvent = $this->getListMedicine();
        return Datatables::of($listEvent)
            ->addColumn('action', function ($listEvent) {
                return '<a href="editMedicines/' . $listEvent->id . '" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Edit</a> <a id="' . $listEvent->id . '" onclick="deleteNews(this)" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Delete</a>';
            })->make(true);
    }

    public function loadcreate(Request $request)
    {
        return view('admin.medicines.create');
    }

    public function loadList(Request $request)
    {
        return view('admin.medicines.list');
    }

    public function loadedit($id)
    {
        return view("admin.medicines.edit", ['Medicines' => $this->loadeditMedicine($id)]);
    }

    public function edit(Request $request, $id)
    {

        $input = $request->all();
        if ($this->editMedicine($input, $id)) {
            return redirect()->route("admin.list.medicines")->withSuccess("Thuốc đã được chỉnh");
        } else {
            return redirect()->back()->withSuccess("Thuốc chưa được chỉnh");
        }

    }

    public function delete($id)
    {
        if ($this->deleteMedicines($id)) {
            return redirect('admin/list-Medicines')->withSuccess("Thuốc đã được xóa");
        } else {
            return redirect('admin/list-Medicines')->withSuccess("Thuốc chưa được xóa");
        }
    }
}
