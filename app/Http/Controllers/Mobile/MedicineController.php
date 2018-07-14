<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 14-Jul-18
 * Time: 20:32
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\MedicineBusinessFunction;
use Exception;

class MedicineController extends BaseController
{
    use MedicineBusinessFunction;

    public function getAll()
    {
        try {
            $medicines = $this->getListMedicine();
            return response()->json($medicines, 200);
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi server", $ex);
            return response()->json($error, 500);
        }
    }
}