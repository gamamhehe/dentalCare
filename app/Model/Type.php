<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    protected $table = 'tbl_types';
    protected $fillable = ['id', 'type'];
    public function hasNews(){
        return $this->hasMany('App\Model\NewsType','type_id', 'id');
    }
}
