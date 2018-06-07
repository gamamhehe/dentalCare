<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Treatment_image extends Model
{
    //
    protected $table = 'tbl_treatment_images';
    protected $fillable = ['id', 'treatment_detail_id', 'image_link', 'create_date'];
}
