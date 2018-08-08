<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 05-Aug-18
 * Time: 08:26
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class FirebaseToken extends  Model
{
    protected $table = 'tbl_firebase_tokens';
    protected $fillable = ['phone', 'noti_token'];

    public function belongsToUser(){
        return $this->belongsTo('App\Model\User', 'phone', 'phone');
    }
}