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
use Illuminate\Http\Request;

class HistoryTreatmentController extends Controller
{
    use TreatmentBusinessFunction;
    use UserBusinessFunction;
    use TreatmentHistoryBusinessFunction;

    public function getByPhone($phone)
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