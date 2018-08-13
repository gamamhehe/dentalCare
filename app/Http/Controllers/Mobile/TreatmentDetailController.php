<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 18-Jul-18
 * Time: 20:01
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\TreatmentDetailBusinessFunction;
use App\Model\MedicinesQuantity;
use App\Model\TreatmentHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TreatmentDetailController extends BaseController
{
    use TreatmentDetailBusinessFunction;

    public function getAll()
    {
        try {
            $treatmentDetails = $this->getAllTreatmentDetail();
            return response()->json($treatmentDetails, 200);
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }

    }

    public function getById($id)
    {
        try {
            $treatmentDetail = $this->getTreatmentDetailById($id);
            return response()->json($treatmentDetail, 200);
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }
    }

    public function create(Request $request)
    {
//        var_dump($request->all());
//        return;
        try {
            $tmHistoryId = $request->input('treatment_history_id');
            $staffId = $request->input('staff_id');
            $treatmentDetailNote = $request->input('detail_note');
            $images = $request->file('images');
            $medicineIds = $request->input('medicine_id');
            $medicineQuantities = $request->input('medicine_quantity');
            $detailStepIds = $request->input('step_id');
            $medicines = [];
            for ($i = 0; $i < count($medicineIds); $i++) {
                $medicine = new MedicinesQuantity();
                $medicine->medicine_id = $medicineIds[$i];
                $medicine->quantity = $medicineQuantities[$i];
                $medicines[] = $medicine;
            }
            $result = $this->createTreatmentDetailWithModel(
                $tmHistoryId,
                $staffId,
                $treatmentDetailNote,
                $detailStepIds,
                $medicines,
                $images);
            if ($result) {
                $successResponse = $this->getSuccessObj(200, "OK", "Thêm điều trị chi tiết thành công", "No data");
                return response()->json($successResponse, 200);
            } else {
                $error = $this->getErrorObj("Không thể lưu thông tin chi tiết điều trị", "No exception");
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi server", $ex);
            return response()->json($error, 400);
        }
    }


}