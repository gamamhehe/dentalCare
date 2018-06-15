<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/14/2018
 * Time: 8:11 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\Patient;
use App\Model\TreatmentHistory;
use App\Model\User;

trait TreatmentBusinessFunction
{
    public function getTreatmentHistory($phone){
        $patientList = User::where('phone', $phone)->first()->hasPatient()->get();
        dd($patientList);
    }

    public function  getTreatmentHistories($phone){
        $treatmentHistories = Patient::where('phone',$phone)->first()->hasTreatmentHistory()->get();
        return $treatmentHistories;
    }
}