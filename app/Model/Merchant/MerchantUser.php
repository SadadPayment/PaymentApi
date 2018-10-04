<?php

namespace App\Model\Merchant;

use Illuminate\Database\Eloquent\Model;

class MerchantUser extends Model
{
    //
    public function merchant(){
        return $this->belongsTo('App\Model\Merchant');
    }
    public function user(){
        return $this->belongsTo('App\Model\User');
    }
}
