<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    //
    protected $table = 'tbl_medicines';
    protected $fillable = ['id', 'name', 'use', 'description'];
}
