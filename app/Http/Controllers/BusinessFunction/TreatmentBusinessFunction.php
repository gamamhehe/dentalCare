<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/14/2018
 * Time: 8:11 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\Treatment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait TreatmentBusinessFunction
{
    public function getAllTreatment(){
        $listTreat = Treatment::all();
        foreach ($listTreat as $treatment){
            $treatment->treatment_steps = $treatment->hasTreatmentStep()->get();
            $treatment->category = $treatment->belongsToTreatmentCategory()->first();
        }
        return $listTreat;
    }
    public function deleteTreatment($id){
        DB::beginTransaction();
        try{
            $Treatment = Treatment::where('id', $id)->first();
            $Treatment->delete();
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollback();
            return false;

        }
    }
    public function getTreatmentByCategori($id){
        $listTreat = Treatment::where('treatment_category_id','=',$id)->get();
        return $listTreat;
    }
    public function createTreatment($input){
        DB::beginTransaction();
        try{
            $Treatment = new Treatment();
            $Treatment->name =  $input['name'];
            $Treatment->treatment_category_id = $input['TreatmentCate'];
            $Treatment->description =$input['description'];
            $Treatment->max_price =(int)$input['max_price'];
            $Treatment->min_price =(int)$input['min_price'];
            $Treatment->save();
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollback();
            return  false;
        }
    }
    public function getTreatmentByID($id){
        $Treatment = Treatment::find($id);
        return $Treatment;
    }
    public function editTreatment($input,$id){
        DB::beginTransaction();
        try{
            $Treatment = Treatment::find($id);
            $Treatment->name =  $input['name'];
            $Treatment->treatment_category_id = $input['TreatmentCate'];
            $Treatment->description =$input['description'];
            $Treatment->max_price =(int)$input['max_price'];
            $Treatment->min_price =(int)$input['min_price'];
            $Treatment->save();
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollback();
            return false;
        }
    }

    public function showTreatmentStepForTreatment($idTreatment)
    {
        $listTreatmentStep = Treatment::find($idTreatment)->hasTreatmentStep()->get();
        $result = [];
        foreach ($listTreatmentStep as $treatmentStep) {
            $result[] = $treatmentStep->belongsToStep()->first();
        }
        return $result;
    }
}