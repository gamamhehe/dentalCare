<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TreatmentImage extends Model
{
    //
    protected $table = 'tbl_treatment_images';
    protected $fillable = ['id', 'treatment_detail_id', 'image_link', 'created_date'];

    public function belongsToTreatmentDetail(){
        return $this->belongsTo('App\Model\TreatmentDetail', 'treatment_detail_id', 'id');
    }
}
