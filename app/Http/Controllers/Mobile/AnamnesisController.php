<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 11-Jul-18
 * Time: 01:30
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\AnamnesisBusinessFunction;
use Exception;

class AnamnesisController extends BaseController
{
    use AnamnesisBusinessFunction;

    public function getAll()
    {
        try {
            $anamesises = $this->getAllAnamnesis();
            return response()->json($anamesises, 200);
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi server", $ex);
            return response()->json($error, 500);
        }
    }
}