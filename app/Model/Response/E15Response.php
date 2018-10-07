<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

class E15Response extends Model
{
    //
    public function E15(){
        return $this->belongsTo('App\Model\Payment\E15');
    }
    public function PaymentResponse(){
        return $this->belongsTo('App\Model\Response\PaymentResponse' , 'payment_response_id');
    }

}
