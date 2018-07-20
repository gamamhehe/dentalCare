<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Http\Controllers\Controller;
use App\Model\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends BaseController
{
    use TreatmentBusinessFunction;

    public function getAll()
    {
        try {
            $treatments = $this->getAllTreatment();
            return response()->json($treatments, 200);
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra";
            $error->exception = $ex->getMessage();
            return response()->json($error, 500);
        }
    }

    public function getById($id)
    {
        $treatment = null;
        try {
            $treatment = $this->getTreatmentByID($id);
            if ($treatment != null) {
                return response()->json($treatment, 200);
            } else {
                $error = new \stdClass();
                $error->error = "Không tìm thấy " . $id;
                $error->exception = "Nothing";
                return response()->json($error, 500);
            }
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi server", $ex);
            return response()->json($error, 500);
        }
    }
}
