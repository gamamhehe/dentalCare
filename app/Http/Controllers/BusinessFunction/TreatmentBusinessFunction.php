<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/14/2018
 * Time: 8:11 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\Patient;
use App\Model\Treatment;
use App\Model\TreatmentDetail;
use App\Model\TreatmentDetailStep;
use App\Model\Payment;
use App\Model\TreatmentHistory;
use App\Model\TreatmentImage;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait TreatmentBusinessFunction
{
    use PaymentBusinessFunction;
    use EventBusinessFunction;
    public function getAllTreatment(){
        $listTreat = Treatment::all();
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