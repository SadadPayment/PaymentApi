<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class E15Service extends Model
{
    //
    public function service(){
        return $this->belongsTo('App\Model\Merchant\MerchantServices');
    }
}
