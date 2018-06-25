<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NodeInfo extends Model
{
    protected $table = 'tbl_node_info';
    protected $fillable = ['ip_server', 'name_hopital'];
    
}
