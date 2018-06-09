<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 07-Jun-18
 * Time: 19:47
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;
use App\Model\TreatmentCategory;
use http\Env\Request;
use Mockery\Exception;

class TreatmentCategoryController extends Controller
{
    public function getAll()
    {
        try {
            $tmCategories = TreatmentCategory::all();
            return response()->json($tmCategories, 200);
        } catch (Exception $ex) {
            $error = new \stdClass();
            $error->error = "Không có dữ liệu";
            $error->exception = $ex;
            return response()->json($error, 400);
        }
    }

    public function getById(Request $request)
    {
        try {
            $id = $request->input('id');
            $error = new \stdClass();
            $treatmentCategory = TreatmentCategory::where('id', $id)->first();
            if ($treatmentCategory != null) {
                return response()->json($treatmentCategory, 200);
            } else {
                $error->error = "Không tìm thấy treatement " . $id;
                $error->exception = "No exception";
                return response()->json($error, 400);
            }
        } catch (Exception $ex) {
            $error->error = "Có lỗi xảy ra!";
            $error->exception = $ex;
            return response()->json($error, 400);
        }
    }
}