<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 11-Aug-18
 * Time: 23:15
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Symptom;

trait SymptomBusinessFunction
{
    public function getAllSymptoms(){
        $symptoms = Symptom::all();
        return $symptoms;
    }
}