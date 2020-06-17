<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    protected $table="posts";
    
    public function categories()
    {
        return $this->belongsToMany('App\categories', 'category_post', 'post_id', 'category_id');
    }
}
