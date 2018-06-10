<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'tbl_roles';
    protected $fillable = ['id', 'name', 'description'];
    public function roleBelongTo(){
        return $this->hasMany('App\Model\UserHasRole','role_id', 'id');
    }
}
