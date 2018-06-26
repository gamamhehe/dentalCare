<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    //
    protected $table = 'tbl_queues';
    protected $fillable = ['id', 'dataEncrypt', 'status', 'ip'];

    public function belongsToServer(){

    }
}
