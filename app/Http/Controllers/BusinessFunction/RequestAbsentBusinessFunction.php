<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 20-Jul-18
 * Time: 22:31
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\RequestAbsent;
use Illuminate\Support\Facades\DB;

trait RequestAbsentBusinessFunction
{
    public function getAll()
    {
        $listRequestAbsent = RequestAbsent::all();
        return $listRequestAbsent;
    }

    public function getById($id)
    {
        $requestAbsent = RequestAbsent::where('id', $id)->first();
        return $requestAbsent;
    }

    public function createListRequestAbsent($listRequestAbsent)
    {
        DB::BeginTransaction();
        try {

            foreach ($listRequestAbsent as $requestAbsent) {
                $requestAbsent->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollback();
            throw new \Exception($ex->getMessage());
        }
    }

    public function createRequestAbsent($requestAbsent)
    {
        try {
            $requestAbsent->save();
            return $requestAbsent;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}