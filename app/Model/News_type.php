<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News_type extends Model
{
    //
    protected $table = 'tbl_news_type';
    protected $fillable = ['type_id', 'news_id'];
    public function belongsToType(){
        return $this->belongsTo('App\Model\News', 'news_id', 'id');
    }
    public function getType(){
        return $this->belongsTo('App\Model\Type', 'type_id', 'id');
    }
}
