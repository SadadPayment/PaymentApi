<?php

namespace App;

use App\Model\Account\AccountType;
use App\Model\Account\BankAccount;
use App\Model\Account\MobileAccount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use phpseclib\Crypt\RSA;

class Functions
{
    //
    public static function getBankAccountByUser($user){
        return BankAccount::where('user_id', $user->id)->first();
    }
    public static function getMobileAccountByUser($user){
        return MobileAccount::where('user_id', $user->id)->first();
    }

    public static function getDateTime()
    {
        $now = Carbon::now();
        $day = $now->day >= 10 ? $now->day : "0" . $now->day;
        $mounth = $now->month >= 10 ? $now->month : "0" . $now->month;
        $year = $now->year - 2000;

        $hour = $now->hour >= 10 ? $now->hour : "0" . $now->hour;

        $minute = $now->minute >= 10 ? $now->minute : "0" . $now->minute;
        $second = $now->second >= 10 ? $now->second : "0" . $now->second;
        $convert = "" . $day . "" . $mounth . "" . $year . "" . $hour . "" . $minute . "" . $second . "";
        return $convert;
    }



    public static function convertExpDate($expDate){
//        dd($expDate);
        $car =Carbon::parse($expDate);
        //dd($car);
        $month=$car->month;
        if ($month < 10){
            $month = "0".$month;
        }
        $year = $car->year;
        $year -=2000;
        $resualt = "";
        $resualt = $resualt.$year.''.$month;
        //dd($resualt);
        return $resualt;
    }

    public static function getAccountTypeId($account)
    {
        return AccountType::where("name", $account)->first();
    }

    public static function encript($publicKey, $uuid, $ipin)
    {
        $rsa = new RSA();

        $rsa->loadKey($publicKey);

        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        $ciphertext = $rsa->encrypt($uuid . $ipin);
        $ciphertext =base64_encode($ciphertext);
        return $ciphertext;
    }
}
