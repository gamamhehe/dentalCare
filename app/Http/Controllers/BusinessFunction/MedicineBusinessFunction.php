<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\Medicine;
use App\Model\MedicinesQuantity;
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

    public function deleteMedicines($id)
    {
        DB::beginTransaction();
        try {
            $Medicine = Medicine::where('id', $id)->first();
            $Medicine->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
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

    public function getListMedicine()
    {
        return Medicine::all();
    }

    public function createMedicineForTreatmentDetail($listMedicine, $treatment_detail_id, $listQuantity)
    {
        DB::beginTransaction();
        try {
            if ($listMedicine) {
                for ($i = 0; $i < count($listMedicine); $i++) {
                    MedicinesQuantity::create([
                        'medicine_id' => $listMedicine[$i],
                        'treatment_detail_id' => $treatment_detail_id,
                        'quantity' => $listQuantity[$i]
                    ]);
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }
    }

    public function loadMedicineOfTreatmentDetail($treatment_detail_id)
    {
        $listMedicines = MedicinesQuantity::where('treatment_detail_id', $treatment_detail_id)->get();
        foreach ($listMedicines as $key) {
            $key->medicineName = $key->belongsToMedicine()->first();
        }
        return $listMedicines;
    }

    public function getMedicineByName($medicine)
    {
        return Medicine::where('name', 'like', '%' . $medicine . '%')->get();
    }
}