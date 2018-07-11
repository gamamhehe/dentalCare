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
use App\Model\Blockchain;
use App\RequestAbsent;
use Carbon\Carbon;

trait BlockchainBusinessFunction
{
    public function getDataBlockChain()
    {
        $blockchains = Blockchain::all();
   
        return $blockchains;
    }
}