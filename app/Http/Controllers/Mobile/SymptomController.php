<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BusinessFunction\SymptomBusinessFunction;
use App\Model\City;
use App\Model\District;
use App\Model\Symptom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SymptomController extends BaseController
{
    use SymptomBusinessFunction;

    public function getAll()
    {
        try {
            $symptom = $this->getAllSymptoms();
            return response()->json($symptom);
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chũ", $ex);
            return response()->json($error, 500);
        }
    }
}
