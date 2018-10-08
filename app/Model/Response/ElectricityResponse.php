<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

class ElectricityResponse extends Model
{
    protected $fillable = ["meterFees" , "netAmount" , "unitsInKWh" , "waterFees" , "token" , "customerName" , "opertorMessage"];
    //
    public function PaymentResponse(){
        return $this->belongsTo('App\Model\Response\PaymentResponse' , 'payment_response_id');
    }
    public function Electriciy(){
        return $this->belongsTo('App\Model\Payment\Electricity' , 'electricity_id');
    }
}
