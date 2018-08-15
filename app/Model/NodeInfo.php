<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NodeInfo extends Model
{
    protected $table = 'tbl_node_info';
    protected $fillable = ['ip', 'name'];

    public function hasQueue(){
        return $this->hasMany('App\Model\Queue', 'ip', 'ip');
    }

    public function belongsToKey(){
        return $this->belongsTo('App\Model\Key', 'ip', 'ip');
    }

}
