<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Absent;
use App\Model\Blockchain;
use App\Model\Role;
use App\RequestAbsent;
use Carbon\Carbon;

trait BlockchainBusinessFunction
{

    public function saveNewAll($ledgerInJson)
    {
        $ledgerObject = json_decode($ledgerInJson, true);
        if ($ledgerObject != null) {
            Blockchain::query()->delete();
            $count = 0;
            foreach ($ledgerObject as $element) {
                $block = new Blockchain();
                $tmp = (Object)$element;
                $block->data_encrypt = $tmp->data_encrypt;
                $block->previous_hash = $tmp->previous_hash;
                $block->hash = $tmp->hash;
                $block->save();
                $count++;
            }
            return json_encode($count);
        }
        return '0';
    }


    public function getDataBlockChain()
    {
        $blockchains = Blockchain::all();
        return $blockchains;
    }

}