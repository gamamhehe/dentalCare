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

    public function createForTreatmentDetail(Request $request)
    {
        $listMedicine = $request->medicine;
        $listQuantity = $request->quantity;
        $treatment_detail_id = $request->treatment_detail_id;
        $this->createMedicineForTreatmentDetail($listMedicine, $treatment_detail_id, $listQuantity);
    }

    public function loadOfTreatmentdetail(Request $request){
        $treatment_detail_id = $request->treatment_detail_id;
        $listMedicineQuantity = $this->loadMedicineOfTreatmentDetail($treatment_detail_id);
        $listMedicine = [];
        $listQuantity = [];
        foreach ($listMedicineQuantity as $medicineQuantity){
            $listMedicine[] = $medicineQuantity->belongsToMedicine()->first();
            $listQuantity[] = $medicineQuantity->quantity;
        }
    }

}
