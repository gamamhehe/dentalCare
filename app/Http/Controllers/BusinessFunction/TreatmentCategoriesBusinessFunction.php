<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/14/2018
 * Time: 8:11 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\Patient;
use App\Model\Treatment;
use App\Model\TreatmentCategory;
use App\Model\TreatmentDetail;
use App\Model\TreatmentDetailStep;
use App\Model\Payment;
use App\Model\TreatmentHistory;
use App\Model\TreatmentImage;
use App\Model\User;
use Carbon\Carbon;

trait TreatmentCategoriesBusinessFunction
{
    // use PaymentBusinessFunction;
    // use EventBusinessFunction;
    public function getAllTreatmentCategories(){
        $listTreatmentCategory = TreatmentCategory::all();
        return $listTreatmentCategory;
    }


}