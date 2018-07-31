<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/17/2018
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\AnamnesisCatalog;
use App\Model\AnamnesisPatient;
use Illuminate\Support\Facades\DB;

trait AnamnesisBusinessFunction
{
    public function createAnamnesis($input){
        DB::beginTransaction();
        try {
            $AnamnesisCatalog = new AnamnesisCatalog;
            $AnamnesisCatalog->name = $input['name'];
            $AnamnesisCatalog->description =  $input['description'];
            $AnamnesisCatalog->save();
            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }
    }
    public function getAllAnamnesis(){
        $listAnamnesis = AnamnesisCatalog::all();
        return $listAnamnesis;
    }
    public function deletAnamnesis($id)
    {
        DB::beginTransaction();
        try{
            $AnamnesisCurrent = $this->getAnamnesis($id);
            $AnamnesisCurrent->delete();
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollback();
            return false;

        }
    }
    public function editAnamnesis($input,$id){
        DB::beginTransaction();
        try{

            $AnamnesisCatalog = AnamnesisCatalog::where('id', $id)->first();
            $AnamnesisCatalog->name = $input['name'];
            $AnamnesisCatalog->description =  $input['description'];
            $AnamnesisCatalog->save();
            DB::commit();
            return redirect('admin/list-Anamnesis')->withSuccess("Loại bệnh đã được chỉnh sửa");

        }catch(\Exception $e){
            DB::rollback();
            return redirect('admin/list-Anamnesis')->withSuccess("Loại bệnh chưa được chỉnh sửa");
        }
    }
    public function getAnamnesis($id){
        $AnamnesisCatalog = AnamnesisCatalog::find($id);
        return $AnamnesisCatalog;
    }

    public function getListAnamnesisByPatient($id){
        $AnamnesisPatient = AnamnesisPatient::where('patient_id',$id)->get();
        foreach ($AnamnesisPatient as $key) {
            $key->name = $key->belongsToAnamnesisCatalog()->first();
        }
        return null;
    }
    public function createAnamnesisForPatient($array,$patientId){
        foreach ($array as $key => $value) {
            $result = $this->createAnamnesisPatient($value,$patientId);
            if($result==false){
                return false;
            }
        }
        return true;
    }
    public function createAnamnesisPatient($anamId,$patientId){
        DB::beginTransaction();
        try{

            $AnamnesisPatient = new AnamnesisPatient;
            $AnamnesisPatient->patient_id = $patientId;
            $AnamnesisPatient->anamnesis_id =  $anamId;
            $AnamnesisPatient->description =  "";
            $AnamnesisPatient->save();
            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            return false;
        }
    }
}