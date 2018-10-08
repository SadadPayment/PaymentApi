<?php

namespace App\Http\Controllers\API;

use App\Model\Payment\Payment;
use App\Model\Response\ElectricityResponse;
use App\Model\Transaction;
use App\Model\TransactionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
//use Tymon\JWTAuth\JWTAuth;

class ElectHistoryApiController extends Controller
{

    public function index()
    {
        return response()->json(['data'=> ' ']);
    }

    public function getByUsers(){
        $response = array();
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();

        $transction_type = TransactionType::where('name', "Electericity")->pluck('id')->first();
        $tran = Transaction::where('user_id', '=', $user->id)->where("transaction_type",$transction_type)->get();

        foreach ($tran as $transaction ){
            $payment =Payment::where("transaction_id" , $transaction->id)->first();

            $electricity =\App\Model\Payment\Electricity::where("payment_id" , $payment->id)->first();

            $electriciy_response = ElectricityResponse::where("electricity_id" , $electricity->id)->first();

            if ($electriciy_response != null)
                $response[]= $electriciy_response;
        }
        return response()->json(['data'=>$response]);
    }
}


