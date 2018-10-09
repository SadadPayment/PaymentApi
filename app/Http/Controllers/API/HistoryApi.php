<?php

namespace App\Http\Controllers\API;

use App\Model\Response\Response;
use App\Model\Transaction;
use App\Model\TransactionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class HistoryApi extends Controller
{
    //
    public function getAllTransactionsByUser(){
        $response = array();
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();


        $tran = Transaction::where('user_id', '=', $user->id)->get();


        foreach ($tran as $transaction ){

            $transction_type = TransactionType::where('id', $transaction->transaction_type)->pluck('name')->first();
            $res = Response::where("transaction_id" , $transaction->id)->first();

            $res_a = (array) $res;

            $res_a += ["type" => $transction_type];
            $response[]=$res_a;

        }
        return response()->json(['data'=>$response]);
    }
}
