<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Absent;
use App\Model\NodeInfo;
use App\Model\Role;
use App\RequestAbsent;
use Carbon\Carbon;

trait NodeInfoBusinessFunction
{
    public function isExist($ip)
    {
        $check = NodeInfo::where('ip', '=', $ip)->first();
        if ($check != null) {
            return true;
        }
        return false;
    }

    public function getListNode()
    {
        $listNode = NodeInfo::all();
        return $listNode;
    }

}