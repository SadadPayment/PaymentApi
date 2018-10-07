<?php

namespace App\Model;

use App\Model\Account\BankAccount;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    //
    const Payment = "payment";
    public function type(){
        return $this->belongsTo('App\Model\TopUpType' , 'type_id');
    }
    public function biller(){
        return $this->belongsTo('App\Model\TopUpBiller' , 'biller_id');
    }
    public static function getTopUp($type_id, $biller_id)
    {
        return self::where('type_id', $type_id)->where('biller_id', $biller_id)->first();
    }
    public static function requestBuild($transaction_id, $topUpAmount , $payee_id ,$phone,$ipin)
    {
        $transaction = Transaction::where("id", $transaction_id)->first();
        $user = User::where("id",$transaction->user_id)->first();
        $payment = Payment::where("transaction_id", $transaction_id)->first();


        //return ["id" => $payment->service];
        $tranCurrency = "SDG";
        $tranAmount = "";

        $tranAmount = $topUpAmount;

        $request = array();
        $request += ["applicationId" => "Sadad"];
        //$tr = array();
        //$tr += ["tranDateTime" => $transaction->transDateTime];

        //return $tr;

        $transDateTime = $transaction->transDateTime;

        $request += ["tranDateTime" => $transDateTime];
        $uuid = $transaction->uuid;
        $request += ["UUID" => $uuid];
        $request += ["tranCurrency" => $tranCurrency];
        $request += ["tranAmount" => $tranAmount];
        $userName = "";
        $userPassword = "";
        $entityId = "";
        $entityType = "";
        $authenticationType = "00";
        $bank = BankAccount::getBankAccountByUser($user);
        $PAN = $bank->PAN;
        $mbr = $bank->mbr;
        $expDate = $bank->expDate;



        $request += ["userName" => $userName];
        $request += ["userPassword" => $userPassword];
        //$request += ["entityId" => $entityId];
        $request += ["entityType" => $entityType];
        $request += ["PAN" => $PAN];

        $paymentInfo = "MPHONE =" . $phone;
        $request += ["paymentInfo" => $paymentInfo];

        $request += ["payeeId" => $payee_id];
        $request += ["mbr" => $mbr];
        $request += ["expDate" => $expDate];
        $request += ["IPIN" => $ipin];
        //echo $IPIN . "<br>";
        $request += ["authenticationType" => $authenticationType];
        $request += ["fromAccountType" => "00"];

        return $request;
        //$request->tranDateTime = $transaction->transDateTime;
    }
    public static function sendRequest($transaction_id, $topUpAmount , $payee_id ,$phone,$ipin){
        $request = self::requestBuild($transaction_id, $topUpAmount , $payee_id ,$phone,$ipin);

        $response = SendRequest::sendRequest($request , self::Payment);
        return $response;

    }


}
