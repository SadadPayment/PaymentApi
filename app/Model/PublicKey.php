<?php

namespace App\Model;

use Webpatser\Uuid\Uuid;
use GuzzleHttp\Client;
use GuzzleHttp;
use phpseclib\Crypt\RSA;

class PublicKey
{
    //
    const PublicKey = "getPublicKey"; // the publicKey method in EBS Server
    public static function requestBuild(){
        $tranDateTime = DateTime::getDateTime();
        $uuid=Uuid::generate()->string;
        $applicationId = "Sadad";
        $request = array();
        $request += ["applicationId" => $applicationId];
        $request += ["UUID" => $uuid];
        $request += ["tranDateTime" => $tranDateTime];

        return $request;
    }
    /*
     *  @Params :
     *      ipin the ipin which we want to encript
     *
     *  @Return:
     *      Encripted ipin using the public key from EBS
     */
    public static function sendRequest(){
        //dd($ipin);
        $request = self::requestBuild();
        $response = SendRequest::sendRequest($request , self::PublicKey);
        if ($response != false)
            return $response->pubKeyValue;
        return false;
    }
    /*
     *  @Params :
     *      publicKey the publickey which we resolved from EBS
     *      uuid the uuid which send to ebs for encription
     *      ipin the ipin which we want to encript
     *   @Return:
     *      Encripted ipin
     */
}
