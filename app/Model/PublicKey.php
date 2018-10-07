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
    public static function requestBuild($uuid){
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
    public static function sendRequest($ipin){
        $request = self::requestBuild();
        $response = SendRequest::sendRequest($request , self::PublicKey);
        return self::encript($response->pubKeyValue , $request["UUID"] , $ipin);
    }
    /*
     *  @Params :
     *      publicKey the publickey which we resolved from EBS
     *      uuid the uuid which send to ebs for encription
     *      ipin the ipin which we want to encript
     *   @Return:
     *      Encripted ipin
     */
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
