<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blockchain extends Model
{
    //
    protected $table = 'tbl_blockchains';
    protected $fillable = ['id', 'data_encrypt', 'previous_hash', 'hash'];
    public $timestamps = false;

}
