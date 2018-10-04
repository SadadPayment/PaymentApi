<?php

namespace App\Model;


use App\Model\Account\BankAccount;
use App\Model\Payment\Payment;

class Electricity

{
    const Payment = "payment";
    //
    public static function requestBuild($transaction_id, $meter, $amount , $ipin){
        $transaction = Transaction::where("id", $transaction_id)->first();
        $user = User::where("id",$transaction->user_id)->first();
        $payment = Payment::where("transaction_id", $transaction_id)->first();

        $tranCurrency = "SDG";


        $request = array();
        $request += ["applicationId" => "Sadad"];

        $transDateTime = $transaction->transDateTime;

        $request += ["tranDateTime" => $transDateTime];
        $uuid = $transaction->uuid;
        $request += ["UUID" => $uuid];
        $request += ["tranCurrency" => $tranCurrency];
        $request += ["tranAmount" => $amount];
        $userName = "";
        $userPassword = "";
        $entityId = "";
        $entityType = "";
        $PAN = "";
        $mbr = "";
        $expDate = "";
        $authenticationType = "00";
        $bank = BankAccount::getBankAccountByUser($user);
        $PAN = $bank->PAN;
        $mbr = $bank->mbr;
        $expDate = $bank->expDate;

        $payee_id = "0010020001";
        $request += ["payeeId" => $payee_id];
        $payment_info ="METER =" . $meter;
        $request += ["paymentInfo" => $payment_info];

        $request += ["userName" => $userName];
        $request += ["userPassword" => $userPassword];

        $request += ["entityType" => $entityType];
        $request += ["PAN" => $PAN];

        $request += ["mbr" => $mbr];
        $request += ["expDate" => $expDate];
        $request += ["IPIN" => $ipin];
        $request += ["authenticationType" => $authenticationType];
        $request += ["fromAccountType" => "00"];
        return $request;
    }
    public static function sendRequest($transaction_id, $meter, $amount , $ipin){
        $request = self::requestBuild($transaction_id, $meter, $amount , $ipin);

        $response = SendRequest::sendRequest($request , self::Payment);
        return $response;

    }
}
