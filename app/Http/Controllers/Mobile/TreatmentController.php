<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Model\Treatment;
use Illuminate\Http\Request;
use Mockery\Exception;

class TreatmentController extends Controller
{
    public function getAll()
    {
        try {
            $treatments = Treatment::get();
            return response()->json($treatments, 200);
        } catch (Exception $ex) {
            $error = new \stdClass();
            $error->error = "Không có dữ liệu";
            $error->exception = $ex;
            return response()->json($error, 400);
        }
    }

    public function getById($id)
    {
        $treatment = null;
        if ($id != null) {
            $treatment = Treatment::where('id', $id)->first();

            if ($treatment != null) {
                return response()->json($treatment, 200);
            } else {
                $error = new \stdClass();
                $error->error = "Không tìm thấy " . $id;
                $error->exception = "Nothing";
                return response()->json($error, 400);
            }
        }
    }
}
