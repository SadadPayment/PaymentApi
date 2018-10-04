<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    //
    public function transaction(){
        return $this->belongsTo('App\Model\Transaction');
    }
    public static function saveBasicResponse($transaction, $response){
        $basicResonse = new Response();
        $basicResonse->transaction()->associate($transaction);
        $basicResonse->responseCode = $response->responseCode;
        $basicResonse->responseMessage = $response->responseMessage;
        $basicResonse->responseStatus = $response->responseStatus;
        $basicResonse->save();
        return $basicResonse;
    }

}
