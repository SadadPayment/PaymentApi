<?php

namespace App\Model;

use App\Model\Account\BankAccount;
use Illuminate\Database\Eloquent\Model;

class BalanceInquiry extends Model
{
    //
    const Balance = "getBalance";
    public function transaction(){
        return $this->belongsTo('App\Model\Transaction' , "transaction_id");
    }
    public function account_type(){
        return $this->belongsTo('App\Model\Account\AccountType' , "account_type_id");
    }

    public static function requestBuild($transaction_id , $ipin){
        $request = array();
        $transaction = Transaction::where("id", $transaction_id)->first();
        $user = User::where("id",$transaction->user_id)->first();
        $balance_inquiry = BalanceInquiry::where("transaction_id", $transaction_id)->first();
        $request += ["applicationId" => "Sadad"];
        $request += ["tranDateTime" => $transaction->transDateTime];
        $uuid = $transaction->uuid;
        $request += ["UUID" => $uuid];
        $account_type = $balance_inquiry->account_type->name;
        $userName = "";
        $userPassword = "";
        $entityId = "";
        $entityType = "";
        $authenticationType = "00";
        $bank = BankAccount::getBankAccountByUser($user);
        $PAN = $bank->PAN;

        $mbr = $bank->mbr;
        $expDate = $bank->expDate;
        //}
        $request += ["userName" => $userName];
        $request += ["userPassword" => $userPassword];
        $request += ["entityId" => $entityId];
        $request += ["entityType" => $entityType];
        $request += ["PAN" => $PAN];

        $request += ["mbr" => $mbr];
        $request += ["expDate" => $expDate];
        $request += ["IPIN" => $ipin];
        $request += ["authenticationType" => $authenticationType];
        $request += ["fromAccountType" => "00"];


        $tranCurrency = "SDG";
        $request += ["tranCurrency" => $tranCurrency];
        return $request;
    }

    public static function sendRequest($transaction_id, $ipin){
        $request = self::requestBuild($transaction_id, $ipin);

        $response = SendRequest::sendRequest($request , self::Balance);
        return $response;

    }

}
