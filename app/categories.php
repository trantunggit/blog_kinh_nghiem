<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    protected $table="categories";
    
    public function posts()
    {
        return $this->belongsToMany('App\posts', 'category_post', 'category_id', 'post_id');
    }
}
