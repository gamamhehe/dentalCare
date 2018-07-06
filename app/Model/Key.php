<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    protected $table = 'tbl_keys';
    protected $fillable = ['patient_id', 'private_key', 'public_key'];

    
}
