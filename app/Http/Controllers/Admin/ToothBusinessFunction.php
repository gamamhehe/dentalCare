<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 15-Jul-18
 * Time: 14:58
 */

namespace App\Http\Controllers\Admin;


use App\Model\Tooth;

trait ToothBusinessFunction
{
    public function getAllTooth()
    {
        $tooth = Tooth::all();
        return $tooth;
    }
}