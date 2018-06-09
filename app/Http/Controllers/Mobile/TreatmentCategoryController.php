<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 07-Jun-18
 * Time: 19:47
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;
use App\Model\Treatment_category;

class TreatmentCategoryController extends Controller
{
    public function getAll()
    {
        $tmCategories = Treatment_category::all();

        return response()->json($tmCategories, 200);

    }
}