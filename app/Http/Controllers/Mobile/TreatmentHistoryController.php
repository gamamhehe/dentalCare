<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 16-Jun-18
 * Time: 18:37
 */

namespace App\Http\Controllers\Mobile;


use App\Helpers\AppConst;
use App\Http\Controllers\BusinessFunction\HistoryTreatmentBusinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Http\Controllers\BusinessFunction\StaffBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\Controller;
use App\Model\MedicinesQuantity;
use App\Model\Symptom;
use App\Model\TreatmentHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TreatmentHistoryController extends BaseController
{
//    use TreatmentBusinessFunction;
    use UserBusinessFunction;
    use TreatmentHistoryBusinessFunction;
    use PatientBusinessFunction;
    use StaffBusinessFunction;

    public function create(Request $request)
    {
//        Log::info($request->all());
//        return;
        try {
            $treatmentId = $request->input('treatment_id');
            $patientId = $request->input('patient_id');
            $staffId = $request->input('staff_id');
            $description = $request->input('description');
            $treatmentDetailNote = $request->input('detail_note');
            $createdDate = Carbon::now();
//            $finishedDate = $request->input('finish_date');
            $toothNumber = $request->input('tooth_number');
            $price = $request->input('price');
            $images = $request->file('images');
            $medicineIds = $request->input('medicine_id');
            $medicineQuantitys = $request->input('medicine_quantity');
            $detailStepIds = $request->input('step_id');
            $symptomIds = $request->input('symptom_id');
            $medicines = [];
            if ($medicineIds != null && count($medicineIds) > 0) {
                for ($i = 0; $i < count($medicineIds); $i++) {
                    $medicine = new MedicinesQuantity();
                    $medicine->medicine_id = $medicineIds[$i];
                    $medicine->quantity = $medicineQuantitys[$i];
                    $medicines[] = $medicine;
                }
            }
            $symptoms = [];
            if ($symptomIds != null && count($symptomIds) > 0) {
                for ($i = 0; $i < count($symptomIds); $i++) {
                    $symptom = new Symptom();
                    $symptom->symptom_id = $symptomIds[$i];
                    $symptoms[] = $symptom;
                }
            }
//            $paymentId = $request->input('payment_id');
//            $totalPrice = $request->input('total_price');
//1. create treatment history
//2. create treatment detail
//3. create treatment detail step
//4. create medicine quantity
//5. create treatment image[]

            $treatmentHistory = new TreatmentHistory();
            $treatmentHistory->treatment_id = $treatmentId;
            $treatmentHistory->patient_id = $patientId;
            $treatmentHistory->staff_id = $staffId;
            $treatmentHistory->description = $description;
            $treatmentHistory->created_date = $createdDate;
//            $treatmentHistory->finish_date = $finishedDate;
            $treatmentHistory->tooth_number = $toothNumber;
            $treatmentHistory->price = $price;
//            $treatmentHistory->payment_id = $paymentId;
//            $treatmentHistory->total_price = $totalPrice;
            $result = $this->createTreatmentHistory(
                $treatmentHistory,
                $treatmentDetailNote,
                $detailStepIds,
                $medicines,
                $symptoms,
                $images);
            if ($result) {
                $successResponse = $this->getSuccessObj(200, "OK", "Chỉnh sửa thành công", "No data");
                return response()->json($successResponse, 200);
            } else {
                $error = $this->getErrorObj("Không thể lưu thông tin điều trị", "No exception");
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi server", $ex);
            return response()->json($error, 400);
        }


    }

    public function getTreatmentHistoryByPhone($phone)
    {
        try {
            $historyTreatments = $this->getTreatmentHistories($phone);
            return response()->json($historyTreatments, 200);
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra Không thể lấy dữ liệu";
            $error->exception = $ex->getMessage();
            return response()->json($error, 400);
        }
    }

    public function getAll()
    {
        try {
            $treatmentHistories = $this->getAllHistoryTreatments();
            return response()->json($treatmentHistories, 200);
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra Không thể lấy dữ liệu";
            $error->exception = $ex->getMessage();
            return response()->json($error, 400);
        }
    }

    public function getById(Request $request)
    {
        $id = $request->input('id');
        try {
            $historyTreatments = $this->getTreatmentHistory($id);
            return response()->json($historyTreatments, 200);
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra Không thể lấy dữ liệu";
            $error->exception = $ex->getMessage();
            return response()->json($error, 400);
        }
    }

    public function getByPatientId($patientId)
    {
        try {
            $patient = $this->getPatientById($patientId);
            if ($patient == null) {
                $error = new \stdClass();
                $error->error = "Không thể tìm thấy id bệnh nhân";
                $error->exception = "";
                return response()->json($error, 400);
            } else {
                $historyTreatments = $this->getTreatmentHistory($patientId);
                return response()->json($historyTreatments, 200);
            }
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra Không thể lấy dữ liệu";
            $error->exception = $ex->getMessage();
            return response()->json($error, 400);
        }
    }


    public function getTreatmentHistoryReport(Request $request)
    {
        try {
            $staffId = $request->input("staff_id");
            $staffObj = $this->getStaffById($staffId);
            $month = $request->input("month");
            $year = $request->input("year");
            $roleId = $staffObj->belongsToUser()->first()->hasUserHasRole()->first()->role_id;
            $response = "";
            if ($roleId == AppConst::ROLE_DENTIST) {
                $response = $this->getTreatmentReportByDentist($staffId, $month, $year);
            } else {
                $response = $this->getTreatmentReportByReceptionist($month, $year);
            }
            return response()->json($response, 200);
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }
    }
}