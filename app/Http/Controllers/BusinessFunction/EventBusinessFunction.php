<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Event;
use Carbon\Carbon;

trait EventBusinessFunction
{
    public function checkDiscount($idTreatment)
    {
        $event = Event::where('treatment_id', '=', $idTreatment)
            ->where('start_date', '<', Carbon::now())
            ->where('end_date', '>', Carbon::now())
            ->get();
        if($event){
            return $event->discount;
        }else return 0;
    }
}