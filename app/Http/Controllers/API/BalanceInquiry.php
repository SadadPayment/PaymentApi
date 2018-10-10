<?php

namespace App\Http\Controllers\API;

use App\Functions;
use App\Http\Controllers\Controller;
use App\Model\BalanceInquiryResponse;
use App\Model\PublicKey;
use App\Model\Response\Response;
use App\Model\Transaction;
use App\Model\TransactionType;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Webpatser\Uuid\Uuid;
use App\Model\BalanceInquiry as BalanceInquiryModel;

class BalanceInquiry extends Controller
{
    //

    public function balance_inquiry(Request $request){



        if ($request->isJson()){
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            $validator = Validator::make($request->all(),[

                'IPIN' => 'required|numeric|digits_between:4,4',
            ]);

            if ($validator->fails()){
                return response()->json([
                    'error' => true,
                    'errors' => $validator->errors()->toArray()
                ]);
            }
            $ipin = $request->json()->get("IPIN");
            $bank = Functions::getBankAccountByUser($user);
            $account = array();
            if ($ipin !== $bank->IPIN){
                $response = array();
                $response = ["error" => true];
                $response = ["message" => "Wrong IPIN Code"];
                return response()->json($response,200);
            }
            $account += ["PAN" => $bank->PAN];
            $account += ["IPIN" => $bank->IPIN];
            $account += ["expDate" => $bank->expDate];
            $account += ["mbr" => $bank->mbr];


            //$user = JWTAuth::toUser($token);
            /******   Create Transaction Object  *********/
            $transaction = new Transaction();
            $transaction->user()->associate($user);
            $transaction_type = TransactionType::where('name', "Balance Inquiry")->pluck('id')->first();
            $transaction->transactionType()->associate($transaction_type);
            $convert = Functions::getDateTime();


            $uuid = Uuid::generate()->string;
            //$uuid=Uuid::randomBytes(16);

            $transaction->uuid = $uuid;
            $transaction->transDateTime = $convert;
            $transaction->status = "created";
            $transaction->save();
            $balance_inquiry = new BalanceInquiryModel();
            $balance_inquiry->transaction()->associate($transaction);

            $accountType = Functions::getAccountTypeId("bank");
            $balance_inquiry->account_type()->associate($accountType);
            $balance_inquiry->save();

            $publickKey = PublicKey::sendRequest();
            //dd($ipin);
            if ($publickKey == false){
                $res = array();
                $res += ["error" => true];
                $res += ["message" => "Server Error"];
                return response()->json($res,200);
            }
            $ipin = Functions::encript($publickKey , $uuid , $ipin);

            $response = BalanceInquiryModel::sendRequest($transaction->id , $ipin);
            if ($response == false) {
                $res = array();
                $res += ["error" => true];
                $res += ["message" => "Some Error Found"];
                return response()->json($res,200);
            }
            //$basicResonse = Response::saveBasicResponse($transaction, $response);
            //$balance_inquiry_reponse = self::saveBalanceInquiryResonse($basicResonse,$balance_inquiry,$response);

            if ($response->responseCode != 0){
                $res = array();
                $res += ["error" => true];
                $res += ["message" => "Some Error Found"];
                return response()->json($res,200);
            }
            else{
                $res = array();
                $res += ["error" => false];
                $res += ["message" => "Done Successfully"];
                $res += ["balance" => $response->balance];
                return response()->json($res,200);
            }
        }
        else{
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "Request Must Send In Json"];
            return response()->json($response,200);
        }
    }
}
