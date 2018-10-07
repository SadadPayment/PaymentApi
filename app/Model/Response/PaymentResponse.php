<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

class PaymentResponse extends Model
{
    //
    public function payment(){
        return $this->belongsTo('App\Model\Payment\Payment' , 'payment_id');
    }
    public function response(){
        return $this->belongsTo('App\Model\Response\Response' , 'response_id');
    }
    public static function savePaymentResponse($basicResonse, $payment, $response){
        $paymentResponse = new PaymentResponse();
        $paymentResponse->response()->associate($basicResonse);
        $paymentResponse->payment()->associate($payment);
        //dd($response);
        $paymentResponse->balance = $response->balance->available;
        $paymentResponse->acqTranFee = $response->acqTranFee;
        $paymentResponse->issuerTranFee = $response->issuerTranFee;
        $paymentResponse->billInfo = ""; /* $response->billInfo != "" ? $response->billInfo :  */
        //$paymentResponse->balance = 0.0;
        $paymentResponse->save();
        return $paymentResponse;
    }
}
