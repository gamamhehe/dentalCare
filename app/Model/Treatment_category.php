<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Treatment_category extends Model
{
    //
    protected $table = 'tbl_treatment_categories';
    protected $fillable = ['id', 'name', 'description', 'icon_link'];
}
