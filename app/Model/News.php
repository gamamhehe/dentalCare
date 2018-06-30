<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $table = 'tbl_news';
    protected $fillable = ['id', 'image_header', 'content', 'title', 'staff_id', 'create_date'];
    public function hasNewsType(){
        return $this->hasMany('App\Model\NewsType','news_id', 'id');
    }

    public function belongsToStaff(){
        return $this->belongsTo('App\Model\Staff', 'staff_id', 'id');
    }
}
