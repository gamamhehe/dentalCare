<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Absent;
use App\Model\Role;

trait AbsentBusinessFunction
{
    public function checkExistAbsentStaff($staff, $date_absent)
    {
        $checkExistAbsentStaff = Absent::whereColumn([
            ['staff_id', '=', $staff->id],
            ['date_absent', '=', $date_absent]
        ])->get();
        if ($checkExistAbsentStaff != null)
            return false;
        else
            return true;

    }

    public function createAbsent($staff, $date_absent)
    {
            Absent::create([
                'staff_id' => $staff->id,
                'date_absent' => $date_absent,
            ]);
    }

    public function getListAbsentNotApprove(){
        return Absent::whereNull('staff_approve_id');
    }
}