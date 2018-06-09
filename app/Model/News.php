<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $table = 'tbl_news';
    protected $fillable = ['id', 'image_header', 'content', 'title', 'staff_id', 'create_date'];
    public function roleBelongTo(){
        return $this->hasOne('App\Model\UserHasRole','news_id', 'id');
    }
}
