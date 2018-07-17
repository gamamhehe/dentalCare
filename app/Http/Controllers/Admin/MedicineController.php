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
    public function create(Request $request){
        $result = $this->createMedicine($request->all());
          return redirect()->route("admin.list.medicines")->withSuccess("Thuốc đã được tạo");
    }
    public function createForTreatmentDetail(Request $request)
    {
        $listMedicine = $request->medicine;
        $listQuantity = $request->quantity;
        $treatment_detail_id = $request->treatment_detail_id;
        $this->createMedicineForTreatmentDetail($listMedicine, $treatment_detail_id, $listQuantity);
    }
        public function getList()
    {
         $listEvent = $this->getListMedicine();
         return Datatables::of($listEvent)
             ->addColumn('action', function ($listEvent) {
                 return '<a href="edit-medicines/' . $listEvent->id . '" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Chỉnh sửa</a> <a id="' . $listEvent->id . '" onclick="deleteNews(this)" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Xóa</a>';
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
    public function loadOfTreatmentdetail(Request $request)
    {
        $treatment_detail_id = $request->treatment_detail_id;
        $listMedicineQuantity = $this->loadMedicineOfTreatmentDetail($treatment_detail_id);
        $listMedicine = [];
        $listQuantity = [];
        foreach ($listMedicineQuantity as $medicineQuantity) {
            $listMedicine[] = $medicineQuantity->belongsToMedicine()->first();
            $listQuantity[] = $medicineQuantity->quantity;
        }
    }

    public function createPrescription()
    {
        return view('admin.medicines.createPrescription');
    }

    public function ajaxSearch($medicine)
    {
        $output = '';

        $data = $this->getMedicineByName($medicine);


        $total_row = $data->count();


        if ($total_row > 0) {
            foreach ($data as $row) {
                $tmp = "'".$row->name."'";
                $output .= '
        <tr>
         <td>' . $row->name . '</td>
         <td>' . $row->use . '</td>
         <td><button type="button" class="btn btn-default btn-success"
                                        style="margin-right: 10px;float: right;" onclick="addToPrescription('.$tmp.','.$row->id.')">Thêm vào đơn thuốc
                                </button></td>
        </tr>
        ';
            }

        }
        if ($total_row == 0) {
            $output = '
       <tr>
        <td align="center" colspan="5">Không có thuốc này trong danh sách</td>
       </tr>
       ';
        }


        $data = array(
            'table_data' => $output,
            'total_data' => $total_row
        );

        echo json_encode($data);
    }

    public function createPrescriptionForTreatmentDetail(Request $request){
        $this->createMedicineForTreatmentDetail($request->medicine, 1, $request->quantity);
    }
     public function loadedit($id)
    {
        return view("admin.medicines.edit", ['Medicines' => $this->loadeditMedicine($id)]);
    }

    public function edit(Request $request, $id)
    {

        $input = $request->all();
        if ($this->editMedicines($input, $id)) {
            return redirect()->route("admin.list.medicines")->withSuccess("Thuốc đã được chỉnh");
        } else {
            return redirect()->back()->withSuccess("Thuốc chưa được chỉnh");
        }
    }
    public function delete($id)
    {
        if ($this->deleteMedicines($id)) {
            return redirect('admin/list-medicines')->withSuccess("Thuốc đã được xóa");
        } else {
            return redirect('admin/list-medicines')->withSuccess("Thuốc chưa được xóa");
        }
    }
     public function showListAbsentDatatable(){
        $listAbsent = $this->getListAbsentByAdmin();
          return Datatables::of($listAbsent)
            ->addColumn('action', function($listAbsent) {
                return '<a href="edit-news/'.$listAbsent->id.'" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Chỉnh sửa</a> <a id="'.$listAbsent->id.'" onclick="deleteNews(this)" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-edit"></i>Xóa</a>';
            })->make(true);

         
    }

}
