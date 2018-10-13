<?php

namespace App\Http\Controllers\API;

use App\Functions;
use App\Http\Controllers\Controller;
use App\Model\PublicKey;
use App\Model\Transaction;
use App\Model\TransactionType;
use App\Model\Transfer;
use App\Model\TransferType;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Webpatser\Uuid\Uuid;
use App\Model\CardTransfer as CardTransferModel;

class CardTransfer extends Controller
{
    //

    public function card_transfer(Request $request){
        if ($request->isJson()){
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            $validator = Validator::make($request->all(),[

                'to' => 'required|numeric|digits_between:16,19',
                'amount' => 'required|numeric',
                'IPIN' => 'required|numeric|digits_between:4,4',
            ]);

            if ($validator->fails()){

                return response()->json([
                    'error' => true,
                    'errors' => $validator->errors()->toArray()
                ]);
            }
            $to = $request->json()->get("to");
            $amount = $request->json()->get("amount");
            $amount =number_format((float)$amount, 2, '.', '');
            $ipin =  $request->json()->get("IPIN");
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
            $transaction_type = TransactionType::where('name', "Card Transfer")->pluck('id')->first();
            $transaction->transactionType()->associate($transaction_type);
            $convert = Functions::getDateTime();


            $uuid = Uuid::generate()->string;
            //$uuid=Uuid::randomBytes(16);

            $transaction->uuid = $uuid;
            $transaction->transDateTime = $convert;
            $transaction->status = "created";
            $transaction->save();
            $transfer = new Transfer();
            $transfer->transaction()->associate($transaction);
            $transfer->amount = $amount;
            $transfer_type=TransferType::where("name","Card Transfer")->first();
            $transfer->type()->associate($transfer_type);
            $transfer->save();
            $card_transfer = new CardTransferModel();
            $card_transfer->transfer()->associate($transfer);
            $card_transfer->toCard = $to;
            $card_transfer->save();

            $publickKey = PublicKey::sendRequest();
            //dd($ipin);
            if ($publickKey == false){
                $res = array();
                $res += ["error" => true];
                $res += ["message" => "Server Error"];
                return response()->json($res,200);
            }
            $ipin = Functions::encript($publickKey , $uuid , $ipin);

            $response = CardTransferModel::sendRequest($transaction->id,$ipin);
            if ($response == false) {
                $res = array();
                $res += ["error" => true];
                $res += ["message" => "Some Error Found"];
                return response()->json($res,200);
            }

            if ($response->responseCode != 0){
                //dd($response);
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
            return response()->json(["data"=>$response],200);
        }
    }
}
