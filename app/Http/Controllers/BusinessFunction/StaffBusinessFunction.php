<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:47 PM
 */
namespace App\Http\Controllers\BusinessFunction;

use App\Model\Role;
use App\Model\Absent;

trait StaffBusinessFunction{

    public function getCurrentNumberDentist(){
        $totalDentist = count(Role::find('2')->hasUserHasRole()->whereNull('end_time')->get());
        $currentAbsent = Absent::whereDate('date_absent', date("Y-m-d"))->get();
        $countDentistAbsent = 0;
        foreach ($currentAbsent as $staffAbsent){
            if($staffAbsent->belongsToStaff()->first()->belongsToUser()->first()->hasUserHasRole()->first()->belongsToRole()->first()->id == 2){
                $countDentistAbsent++;
            }
        }
        return $totalDentist - $countDentistAbsent;
    }

}