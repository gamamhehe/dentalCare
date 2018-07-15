<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 16-Jun-18
 * Time: 18:37
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\HistoryTreatmentBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\Controller;
use App\Model\TreatmentHistory;
use Illuminate\Http\Request;

class TreatmentHistoryController extends BaseController
{
//    use TreatmentBusinessFunction;
    use UserBusinessFunction;
    use TreatmentHistoryBusinessFunction;


    public function create(Request $request)
    {
        try {
            $treatmentId = $request->input('treatment_id');
            $patientId = $request->input('patient_id');
            $description = $request->input('description');
            $createdDate = $request->input('create_date');
            $finishedDate = $request->input('finish_date');
            $toothNumber = $request->input('tooth_number');
            $price = $request->input('price');
            $paymentId = $request->input('payment_id');
            $totalPrice = $request->input('total_price');

            $treatmentHistory = new TreatmentHistory();
            $treatmentHistory->treatment_id = $treatmentId;
            $treatmentHistory->patient_id = $patientId;
            $treatmentHistory->description = $description;
            $treatmentHistory->create_date = $createdDate;
            $treatmentHistory->finish_date = $finishedDate;
            $treatmentHistory->tooth_number = $toothNumber;
            $treatmentHistory->price = $price;
            $treatmentHistory->payment_id = $paymentId;
            $treatmentHistory->total_price = $totalPrice;
            $result = $this->saveTreatmentHistory($treatmentHistory);
            if ($result) {
                return response()->json($treatmentHistory, 200);
            } else {
                $error = $this->getErrorObj("Không thể lưu thông tin điều trị", "No exception");
                return response()->json($error, 400);
            }
        }catch (\Exception $ex){
            $error = $this->getErrorObj("Lỗi server", $ex);
            return response()->json($error, 500);
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

    public function getByPatientId(Request $request)
    {
        $id = $request->input('id');
        var_dump($id);
        try {
            $patient = $this->getPatientById($id);
            if ($patient == null) {
                $error = new \stdClass();
                $error->error = "Không thể tìm thấy id bệnh nhân";
                $error->exception = "";
                return response()->json($error, 400);
            } else {
                $historyTreatments = $this->getTreatmentHistory($id);
                return response()->json($historyTreatments, 200);
            }
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra Không thể lấy dữ liệu";
            $error->exception = $ex->getMessage();
            return response()->json($error, 400);
        }
    }


}