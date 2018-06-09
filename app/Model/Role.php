<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'tbl_roles';
    protected $fillable = ['id', 'name', 'description'];
    public function roleBelongTo(){
        return $this->hasOne('App\Model\UserHasRole','role_id', 'id');
    }
}
