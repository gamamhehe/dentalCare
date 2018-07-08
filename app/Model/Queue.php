<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    //
    protected $table = 'tbl_queues';
    protected $fillable = ['id', 'data_encrypt', 'status', 'ip'];

    public function belongsToNodeInfo(){
        return $this->belongsTo('App\Model\NodeInfo', 'ip', 'ip');
    }
}
