<?php

namespace App\Http\Controllers\API;

use App\Functions;
use App\Http\Controllers\Controller;
use App\Model\Payment\Payment;
use App\Model\PublicKey;
use App\Model\Response\PaymentResponse;
use App\Model\Response\Response;
use App\Model\Transaction;
use App\Model\TransactionType;
use App\Model\Response\ElectricityResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Webpatser\Uuid\Uuid;
use App\Model\Payment\Electricity as ElectricityModel;

class Electricity extends Controller
{
    //
    public function electricity(Request $request)
    {

        if ($request->isJson()) {
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            $validator = Validator::make($request->all(),[

                'meter' => 'required|numeric|digits_between:10,12',
                'amount' => 'required|numeric',
                'IPIN' => 'required|numeric|digits_between:4,4',
            ]);

            if ($validator->fails()){
                return response()->json([
                    'error' => true,
                    'errors' => $validator->errors()->toArray()
                ]);
            }
            //$user = JWTAuth::toUser($token);
            /******   Create Transaction Object  *********/
            $transaction = new Transaction();
            $transaction->user()->associate($user);
            $meter = $request->json()->get("meter");
            $amount = $request->json()->get("amount");
            $amount =number_format((float)$amount, 2, '.', '');
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

            $transction_type = TransactionType::where('name', "Electericity")->pluck('id')->first();
            $transaction->transactionType()->associate($transction_type);
            $convert = Functions::getDateTime();
            $uuid = Uuid::generate()->string;
            /*
             *  Create Transaction Object
             *
             */
            $transaction->uuid = $uuid;
            $transaction->transDateTime = $convert;
            $transaction->status = "created";
            $transaction->save();
            /*
             *   Create Payment Object
             */
            $payment = new Payment();
            $payment->transaction()->associate($transaction);
            $payment->amount = $amount;
            $payment->save();

            $transaction->status = "Create Electricity";
            $transaction->save();


            $transaction->status = "Save Buy Electricity";
            $transaction->save();

            $electricity = new ElectricityModel();
            $electricity->payment()->associate($payment);
            $electricity->meter = $meter;
            $electricity->save();


            $publickKey = PublicKey::sendRequest();
            //dd($ipin);
            if ($publickKey == false){
                $res = array();
                $res += ["error" => true];
                $res += ["message" => "Server Error"];
                return response()->json($res,200);
            }
            $ipin = Functions::encript($publickKey , $uuid , $ipin);




            $response = ElectricityModel::sendRequest($transaction->id  , $ipin);
            if ($response == false) {
                $res = array();
                $res += ["error" => true];
                $res += ["message" => "Some Error Found"];
                return response()->json($res,200);
            }

            if ($response->responseCode != 0){
                $transaction->status = "Server Error";
                $transaction->save();
                $res = array();
                $res += ["error" => true];
                $res += ["EBS" => $response];

                return response()->json($res, '200');
            }





            else{
                $basicResonse = Response::saveBasicResponse($transaction, $response);

                $paymentResponse = PaymentResponse::savePaymentResponse($basicResonse, $payment, $response);
                $electriciyResponse = self::saveElectriciyResponse($paymentResponse , $electricity , $response);
                $transaction->status = "done";
                $transaction->save();
                $res = array();
                $info = array();
                $info += ["meterFees" => $response->billInfo->meterFees];
                $info += ["netAmount" => $response->billInfo->netAmount];
                $info += ["unitsInKWh" => $response->billInfo->unitsInKWh];
                $info += ["waterFees" => $response->billInfo->waterFees];
                $info += ["token" => $response->billInfo->token];
                $info += ["customerName" => $response->billInfo->customerName];
                $info += ["opertorMessage" => $response->billInfo->opertorMessage];

                $res += ["error" => false];
                $res += ["message" => "Done Successfully"];
                $res += ["info" => $info];

                return response()->json($res, '200');
            }


        } else {
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "Request Must Be Json"];
            return response()->json($response, 200);
        }
    }
    public static function saveElectriciyResponse($paymentResponse , $electricity , $response){
        $electriciy_response = new ElectricityResponse();
        $electriciy_response->PaymentResponse()->associate($paymentResponse);
        $electriciy_response->Electriciy()->associate($electricity);
        $bill_info = (array) $response->billInfo;

//        dd($bill_info);

        //$electriciy_response->
        $electriciy_response->fill($bill_info);
//        $electriciy_response->meterFees = $bill_info->meterFees;
//        $electriciy_response->netAmount = $bill_info->netAmount;
//        $electriciy_response->uinitsInKWh = $bill_info->uinitsInKWh;
//        $electriciy_response->uinitsInKWh = $bill_info->uinitsInKWh;
//        $electriciy_response->waterFees = $bill_info->waterFees;
//        $electriciy_response->token = $bill_info->token;
//        $electriciy_response->customerName = $bill_info->customerName;
//        $electriciy_response->operatorMessage = $bill_info->operatorMessage;
        $electriciy_response->save();
        return $electriciy_response;
    }
}
