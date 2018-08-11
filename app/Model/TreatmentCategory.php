<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TreatmentCategory extends Model
{
    //
    protected $table = 'tbl_treatment_categories';
    protected $fillable = ['id', 'name', 'description', 'icon_link'];
    public function hasTreatment(){
        return $this->hasMany('App\Model\Treatment', 'treatment_category_id', 'id');
    }
}
