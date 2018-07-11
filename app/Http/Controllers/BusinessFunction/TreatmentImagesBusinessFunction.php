<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/14/2018
 * Time: 8:11 PM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\TreatmentImage;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait TreatmentImagesBusinessFunction
{
    public function createTreatmentImage($treatmentDetailId,$image)
    {
        DB::beginTransaction();
        try {
            $TreatmentImage = TreatmentImage::create([
                'treatment_detail_id' => $treatmentDetailId,
                'image_link' => $image,
                'create_date' => Carbon::now()
            ])->id;
            DB::commit();
            return $TreatmentImage;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;

        }
    }
    public function getImageByTreatmentDetail($id){
        $listImg = TreatmentImage::where('treatment_detail_id',$id)->get();
        return $listImg;
    }
 
}