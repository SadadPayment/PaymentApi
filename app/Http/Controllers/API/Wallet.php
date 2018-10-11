<?php

namespace App\Http\Controllers\API;

use App\Functions;
use App\Model\PublicKey;
use App\Model\SendRequest;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class Wallet extends Controller
{
    //
    public function balance_inquiry(){
        $request = array();
        $request += ["applicationId" => "Sadad"];
        $uuid = Uuid::generate()->string;
        $request += ["UUID" => $uuid];
        $request += ["tranDateTime" => Functions::getDateTime()];

        $request += ["userName" => ""];
        $request += ["userPassword" => ""];
        $request += ["entityId" => "249911122380"];
        $request += ["entityType" => "Mobile Wallet"];
        $request += ["tranCurrency" => "SDG"];
        $request += ["PAN" => ""];
        $request += ["mbr" => ""];
        $request += ["expDate" => ""];
        $publickKey = PublicKey::sendRequest();
            //dd($ipin);
        if ($publickKey == false){
            $res = array();
            $res += ["error" => true];
            $res += ["message" => "Server Error"];
            return response()->json($res,200);
        }
        $ipin = Functions::encript($publickKey , $uuid , "2018"); 
        $request += ["IPIN" => $ipin];
        $request += ["authenticationType" => "10"];
        $request += ["fromAccountType" => "00"];

        $response = SendRequest::sendRequest($request , "getBalance");

        return response()->json($response,200);
        
        
    }
}
