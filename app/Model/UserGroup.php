<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    //
    public function users(){
        return $this->hasMany('App\Model\User');
    }
}
