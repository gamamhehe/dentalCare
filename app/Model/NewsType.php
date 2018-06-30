<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NewsType extends Model
{
    //
    protected $table = 'tbl_news_types';
    protected $fillable = ['type_id', 'news_id'];
    public function belongsToNews(){
        return $this->belongsTo('App\Model\News', 'news_id', 'id');
    }
    public function belongsToType(){
        return $this->belongsTo('App\Model\Type', 'type_id', 'id');
    }
}
