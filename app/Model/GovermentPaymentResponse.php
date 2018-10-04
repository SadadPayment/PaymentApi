<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GovermentPaymentResponse extends Model
{
    //
    public function paymentResponse(){
        return $this->belongsTo('App\Model\PaymentResponse','payment_response_id');
    }
    public static function saveGovermentResponse($paymentResponse, $response)
    {
        $govermentResponse = new GovermentPaymentResponse();
        $govermentResponse->paymentResponse()->associate($paymentResponse);
        $govermentResponse->invoiceExpiryDate = $response->invoiceExpiryDate;
        $govermentResponse->invoiceStatus = $response->invoiceStatus;
        $govermentResponse->reciptNo = $response->reciptNo;
        $govermentResponse->unitName = $response->unitName;
        $govermentResponse->serviceName = $response->serviceName;
        $govermentResponse->totalAmountInt = $response->totalAmountInt;
        $govermentResponse->totalAmountInWord = $response->totalAmountInWord;
        $govermentResponse->amountDue = $response->amountDue;
        $govermentResponse->availableBalance = $response->availableBalance;
        $govermentResponse->legerBalance = $response->legerBalance;
        $govermentResponse->tranFee = $response->tranFee;
        $govermentResponse->save();
        return $govermentResponse;
    }
}
