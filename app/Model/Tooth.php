<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tooth extends Model
{
    //
    protected $table = 'tbl_tooths';
    protected $fillable = ['tooth_numnber', 'name'];
}
