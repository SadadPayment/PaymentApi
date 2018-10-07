<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

class TopUpResponse extends Model
{
    //
    protected $fillable = ["status"];
    public function PaymentResponse(){
        return $this->belongsTo('App\Model\Response\PaymentResponse' , 'payment_response_id');
    }
    public function TopUp(){
        return $this->belongsTo('App\Model\Payment\TopUp\TopUp' , 'top_up_id');
    }
}
