<?php

namespace App\Model;

use GuzzleHttp\Client;
use GuzzleHttp;

class SendRequest
{
    const Server = "https://172.16.199.1:8877/QAConsumer/"; // the server of EBS
    /*
     *  @Params:
     *      $req the request data which we want to send
     *      $service the service method or API Endpoint
     *  @Return:
     *      json response from server OR false when timeout occuered
     */
    public static function sendRequest($req , $service){
//        dd($req);
        $req_json= GuzzleHttp\json_encode($req);
        //$req_json = json_encode($req);

        try {
            $client = new Client(['verify' => false ]);
            $response = $client->request('POST', self::Server . $service, [
                'body' => $req_json,
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);
            $body = json_decode($response->getBody());
            return $body;
        } catch (GuzzleHttp\Exception\ConnectException $e) {
            return false;
        }
    }
}
