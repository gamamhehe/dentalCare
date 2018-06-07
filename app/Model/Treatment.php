<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    //
    protected $table = 'tbl_treatments';
    protected $fillable = ['id', 'name', 'description', 'treatment_category_id', 'min_price', 'max_price'];
}
