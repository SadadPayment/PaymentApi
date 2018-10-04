<?php

namespace App\Model\Account;

use Illuminate\Database\Eloquent\Model;

class MobileAccount extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\Model\User',"user_id");
    }
    public function getMobileAccountByUser($user){
        return $this::where('user_id', $user->id)->first();
    }

}
