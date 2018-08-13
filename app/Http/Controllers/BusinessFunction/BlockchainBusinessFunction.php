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
use Illuminate\Support\Facades\Log;

trait BlockchainBusinessFunction
{

    public function saveNewAll($ledgerObject)
    {
        if ($ledgerObject != null) {
            Blockchain::query()->delete();
            $count = 0;
            $number = 1;
            foreach ($ledgerObject as $element) {
                $block = new Blockchain();
                $tmp = (Object)$element;
                $block->data_encrypt = $tmp->data_encrypt;
                $block->previous_hash = $tmp->previous_hash;
                $block->hash = $tmp->hash;
                $result = $block->save();
                if ($result) {
                    $count++;
                } else {
                    Log::info("BlockchainBusinessFunction_saveNewAll_CannotAddBlock: " . $number);
                }
                $number++;
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