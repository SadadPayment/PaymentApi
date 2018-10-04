<?php

namespace App\Model\Account;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\Model\User',"user_id");
    }
    public static function getBankAccountByUser($user){
        return BankAccount::where('user_id', $user->id)->first();
    }
    public static function saveBankAccountByUser($PAN,$IPIN,$expDate,$mbr,$user){
        $bank = new BankAccount();
        $bank->PAN = $PAN;
        $bank->IPIN = $IPIN;
        $bank->expDate = $expDate;
        $bank->mbr = $mbr;
        $bank->user()->associate($user);
        $bank->save();
    }
}
