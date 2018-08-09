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
    public function saveNewAll($ledgerInJson){
        $ledgerObject = json_decode($ledgerInJson, true);
        if ($ledgerObject != null) {
            Blockchain::query()->delete();
            $count = 0;
            foreach ($ledgerObject as $element) {
                $block = new Blockchain();
                $tmp = (Object)$element;
                $block->data_encrypt = $tmp->dataEncrypt;
                $block->previous_hash = $tmp->previousHash;
                $block->hash = $tmp->Hash;
                $block->save();
                $count++;
            }
            return 'done';
        }
    }

    private function get_data($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}