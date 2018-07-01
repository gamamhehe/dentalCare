<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\Medicine;
use Illuminate\Support\Facades\DB;
trait MedicineBusinessFunction
{
    public function createMedicine($input)
    {
        DB::beginTransaction();
        try {
            $medicine = new Medicine();
            $medicine->name = $input['name'];
            $medicine->use = $input['use'];
            $medicine->description = $input['description'];
            $medicine->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return false;
        }
    }

    public function deleteMedicines($id){
        DB::beginTransaction();
        try{
            $Medicine = Medicine::where('id', $id)->first();
            $Medicine->delete();
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollback();
            return false;

        }
    }

    public function editMedicines($input, $id)
    {

        DB::beginTransaction();
        try {
            $Medicines = Medicine::find($id);
            $Medicines->name = $input['name'];
            $Medicines->use = $input['use'];
            $Medicines->description = $input['description'];
            $Medicines->save();
            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }

    }

    public function loadeditMedicine($id)
    {
        return Medicine::find($id);
    }

    public function getListMedicine(){
        return Medicine::all();
    }
}