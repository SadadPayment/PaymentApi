<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

class BalanceInquiryResponse extends Model
{
    //
    public function balanceInquiry(){
        return $this->belongsTo('App\Model\BalanceInquiry');
    }
    public function response(){
        return $this->belongsTo('App\Model\Response');
    }
}
