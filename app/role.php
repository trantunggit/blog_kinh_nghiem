<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(permission::class,'role_permission');
    }
}
