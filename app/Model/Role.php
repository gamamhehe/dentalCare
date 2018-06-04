<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'tblRoles';
    protected $fillable = ['id', 'name', 'description'];
    public function RoleBelongTo(){
        return $this->hasOne('App\Model\User_has_role','role_id', 'id');
    }
}
