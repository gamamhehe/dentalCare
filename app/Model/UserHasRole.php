<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserHasRole extends Model
{
    //
    protected $table = 'tbl_user_has_role';
//    protected $primaryKey = ['phone', 'role_id'];
    protected $fillable = ['phone', 'role_id', 'start_time', 'end_time'];
    public function belongsToUser(){
        return $this->belongsTo('App\Model\User', 'phone', 'phone');
    }
    public function belongsToRole(){
        return $this->belongsTo('App\Model\Role', 'role_id', 'id');
    }
//
//
//    protected function setKeysForSaveQuery(Builder $query)
//    {
//        $keys = $this->getKeyName();
//        if(!is_array($keys)){
//            return parent::setKeysForSaveQuery($query);
//        }
//
//        foreach($keys as $keyName){
//            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
//        }
//
//        return $query;
//    }
//
//    /**
//     * Get the primary key value for a save query.
//     *
//     * @param mixed $keyName
//     * @return mixed
//     */
//    protected function getKeyForSaveQuery($keyName = null)
//    {
//        if(is_null($keyName)){
//            $keyName = $this->getKeyName();
//        }
//
//        if (isset($this->original[$keyName])) {
//            return $this->original[$keyName];
//        }
//
//        return $this->getAttribute($keyName);
//    }
}
