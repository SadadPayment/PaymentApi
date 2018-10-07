<?php

namespace App\Http\Controllers\API;

use App\Functions;
use App\Http\Controllers\Controller;
use App\Model\Payment\Payment;
use App\Model\PublicKey;
use App\Model\Response\E15Response;
use App\Model\Response\PaymentResponse;
use App\Model\Response\Response;
use App\Model\Transaction;
use App\Model\TransactionType;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Webpatser\Uuid\Uuid;
use App\Model\Payment\E15 as E15Model;

class E15 extends Controller
{
    //
    public function e15(Request $request,$type)
    {
        if ($request->isJson()) {
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();

            //$user = JWTAuth::toUser($token);
            /******   Create Transaction Object  *********/
            $transaction = new Transaction();
            $transaction->user()->associate($user);
            //$user = JWTAuth::toUser($token);
            /******   Create Transaction Object  *********/
            $phone = $request->json()->get("phone");
            $amount = $request->json()->get("amount");
            $ipin = $request->json()->get("IPIN");
            $invoice = $request->json()->get("invoiceNo");

            $bank = Functions::getBankAccountByUser($user);
            if ($ipin !== $bank->IPIN){
                $response = array();
                $response = ["error" => true];
                $response = ["message" => "Wrong IPIN Code"];
                return response()->json($response,200);
            }
            if (!isset($invoice)) {
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Insert Invoice Number "];
                return response()->json($response, 200);
            }

            if (!isset($amount)) {
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Insert Amount "];
                return response()->json($response, 200);

            }

            if (!isset($phone)) {
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Insert phone "];
                return response()->json($response, 200);
            }

            $transaction = new Transaction();
            $transaction->user()->associate($user);
            $transaction_type = TransactionType::where('name', "E15")->pluck('id')->first();
            $transaction->transactionType()->associate($transaction_type);

            $convert = Functions::getDateTime();


            $uuid = Uuid::generate()->string;
            //$uuid=Uuid::randomBytes(16);

            $transaction->uuid = $uuid;
            $transaction->transDateTime = $convert;
            $transaction->status = "created";
            $transaction->save();

            $payment = new Payment();
            $payment->transaction()->associate($transaction);
            $payment->amount = $amount;
            $payment->save();

            $e15 = new E15Model();
            $e15->payment()->associate($payment);
            $e15->phone = $phone;
            $e15->invoice_no = $invoice;
            $e15->save();

            $transaction->status = "Send Request";
            $transaction->save();

            $publickKey = PublicKey::sendRequest();
            //dd($ipin);
            if ($publickKey == false){
                $res = array();
                $res += ["error" => true];
                $res += ["message" => "Server Error"];
                return response()->json($res,200);
            }
            $ipin = Functions::encript($publickKey , $uuid , $ipin);


            //$req = E15Model::requestBuild($transaction->id,$ipin,$type);
            $response = json_decode(E15Model::sendRequest($transaction->id,$ipin,$type));

            $basicResonse = Response::saveBasicResponse($transaction, $response);
            $paymentResponse = PaymentResponse::savePaymentResponse($basicResonse, $payment , $response);
            self::saveE15Response($paymentResponse,$e15,$response);


            $json = array();

            $json += ["response" => json_decode($response->getBody())];
            if ($response->responseCode !=0){
                $json += ["error" => true];
                $json += ["message" => "There are some error"];
                $json += ["response" => json_decode($response->getBody())];
                return response()->json($json,200);
            } else {
                $bill_info=$response->billInfo;
                $invoice_status = $bill_info->invoiceStatus;
                $status = "";
                if ($invoice_status == 0){
                    $status = "CANCELED";
                }
                else if ($invoice_status == 1){
                    $status = "PENDING";
                }
                else{
                    $status = "PAID";
                }
                $json += ["error" => false];
                $json += ["message" => "Done Successfully"];
                $json += ["status" => $status];
                $json += ["response" => $bill_info];
                return response()->json($json,200);
            }
            //return response()->json($json,200);



        } else {
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "Request Must Be Json"];
            return response()->json($response, 200);
        }
    }
    public function e15_payment(Request $request){
        return $this->e15($request,6);
    }
    public function e15_inquery(Request $request){
        return $this->e15($request,2);
    }
    public static function saveE15Response( $paymentResponse ,  $e15 , $response){
        $e15_response = new E15Response();
        $e15_response->PaymentResponse()->associate($paymentResponse);
        $e15_response->E15()->associate($e15);
        $bill_info=$response->billInfo;
        $e15_response->invoice_no = $bill_info->invoiceNo;
        $e15_response->expiry = $bill_info->invoiceExpiryDate;
        $e15_response->status = $bill_info->invoiceStatus;
        $e15_response->save();
    }
}
