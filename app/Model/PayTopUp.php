<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PayTopUp extends Model
{
    //
    public function topUp(){
        return $this->belongsTo('App\Model\TopUp','top_up_id');
    }
    public function payment(){
        return $this->belongsTo('App\Model\Payment','payment_id');
    }
}
