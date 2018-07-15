<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 15-Jul-18
 * Time: 14:57
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Admin\ToothBusinessFunction;

class ToothController extends BaseController
{
    use ToothBusinessFunction;

    public function getAll()
    {
        try {
            $listTooth = $this->getAllTooth();
            return response()->json($listTooth, 200);
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi server", $ex);
            return response()->json($error, 500);
        }
    }
}