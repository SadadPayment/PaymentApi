<?php

namespace App\Http\Controllers\API;

use App\Functions;
use App\Http\Controllers\Controller;
use App\Model\CardTransfer;
use App\Model\Electricity;
use App\Model\PublicKey;
use App\Model\Transfer;
use App\Model\TransferType;
use phpseclib\Crypt\RSA;
use Illuminate\Support\Facades\Auth;
use App\Model\BalanceInquiry;
use App\Model\BalanceInquiryResponse;
use App\Model\E15;
use App\Model\PayTopUp;
use App\Model\TopUp;
use App\Model\TopUpBiller;
use App\Model\TopUpType;
use Illuminate\Support\Facades\Hash;
use App\Model\E15Response;
use App\Model\E15Service;
use App\Model\GovermentPaymentResponse;
use App\Model\Account\AccountType;
use App\Model\Account\BankAccount;
use App\Model\Account\MobileAccount;
use App\Model\Merchant\Merchant;
use App\Model\Merchant\MerchantServices;
use App\Model\OurE15;
use App\Model\Payment;
use App\Model\PaymentResponse;
use App\Model\ResetPassword;
use App\Model\Response;
use App\Model\Transaction;
use App\Model\TransactionType;
use App\Model\User;
use App\Model\UserValidation;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp;
use Illuminate\Http\Request;
use Meng\AsyncSoap\Guzzle\Factory;
use Namshi\JOSE\JWT;
use PHPUnit\Util\Json;
use Webpatser\Uuid\Uuid;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    const Server = "https://172.16.199.1:8877/QAConsumer/";

    const PublicKey = "getPublicKey";
    const Payment = "payment";
    const Goverment = "requestGovernmentService";
    const Bill = "getBill";//https://172.16.199.1:8877/QAConsumer/getBill
    const Balance = "getBalance";
    const CardTransfer = "doCardTransfer";
    const AccountTranser = "doAccountTransfer";
    const server = "http://196.29.166.229:8888/E15/GetInvoice.asmx?WSDL";
    const Registertion = "register";
    const GenerateIPIN= "doGenerateIPinRequest";
    const ComplateIPIN = "doGenerateCompletionIPinRequest";
    //


    /*      This will be login        */
    public function authenticate(Request $request)
    {

        $phone = $request->json()->get("phone");
        $ipin = $request->json()->get("IPIN");



        try {

            $passOk= false;
            $user = User::where("phone", $phone)->first();
            if ($user == null){
                $response = array();
                $response += ["error" => true];
                $response += ["message"=>"wrong phone number"];
                return response()->json($response,200);
            }
            $account = BankAccount::where("user_id",$user->id)->where("ipin" , $ipin)->first();


            if (!$account){
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "User Credential Invalid"];
                return response()->json($response, 200);
            }
            //return response()->json(["account"=>$account],200);
            else{
                //$user = Auth::user();
                if ($user->status == "1") {
                    $token = JWTAuth::fromUser($user);

                    $response = array();
                    $response += ["error" => false];
                    $response += ["message" => "OK"];
                    $response += ["token" => $token];
                    return response()->json($response,200);
                }
                else {
                    $response = array();
                    $response += ["error" => true];
                    $response += ["message" => "You Have To Activate Your Account First"];
                    return response()->json($response,200);
                }
            }
        } catch (JWTException $ex) {
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "Something went wrong"];
            return response()->json($response, 200);
        }
    }


    public function registration(Request $request)
    {
        if ($request->isJson()) {
            $user = $request->json();
            $fullName = $user->get("fullName");
            $userName = $user->get("userName");
            $phone = $user->get("phone");
            $password = $user->get("password");
            $PAN = $user->get("PAN");
            $IPIN = $user->get("IPIN");
            $expDate = $user->get("expDate");
            $mbr = "0";

            if (!isset($userName)) {
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Insert userName "];
                return response()->json($response, 200);
            }

            if (!isset($fullName)) {
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Insert fullName "];
                return response()->json($response, 200);

            }

            if (!isset($phone)) {
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Insert phone "];
                return response()->json($response, 200);
            }
            if (!isset($password)) {
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Insert password "];
                return response()->json($response, 200);
            }
            if (!isset($PAN)){
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Insert PAN "];
                return response()->json($response, 200);
            }
            if (!isset($IPIN)){
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Insert IPIN "];
                return response()->json($response, 200);
            }
            if (!isset($expDate)){
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Insert Expiration Date "];
                return response()->json($response, 200);
            }
            if (self::isUsernameFound($userName)) {
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Username Already Exists"];
                return response()->json($response, 200);
            }
            if (self::isPhoneAlreadyRegistered($phone)) {
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Phone Number Already Exists"];
                return response()->json($response, 200);
            }
            $user = new User();
            $user->username = $userName;
            $user->password = Hash::make($password);
            $user->phone = $phone;
            $user->fullName = $fullName;
            $user->save();
            $code = rand(100000, 999999);
            $validate = new UserValidation();
            $validate->phone = $phone;
            $validate->code = $code;
            $validate->save();
            $expDate=Functions::convertExpDate($expDate);
            BankAccount::saveBankAccountByUser($PAN,$IPIN,$expDate,$mbr,$user);
            self::sendSMS($phone, $code);
            $response = array();
            $response += ["error" => false];
            $response += ["message" => "activate Your Account With the code that send to You in SMS"];

            return response()->json($response, 200);
        }
        else{
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "Request Must be json"];
            return response()->json($response, 200);
        }
    }

    public function activate(Request $request)
    {
        $phone = $request->json()->get("phone");
        $code = $request->json()->get("code");


        if (!isset($phone)) {
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "Insert phone "];
            return response()->json($response, 200);
        }

        if (!isset($code)) {
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "Insert code "];
            return response()->json($response, 200);

        }
        if (!self::isPhoneAlreadyRegistered($phone)) {
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "No Number Match this phone"];
            return response()->json($response, 200);
        }
        $validate = UserValidation::where("phone", $phone)->where("code", $code)->get();
        if ($validate->isNotEmpty()) {
            $user = User::where("phone", $phone)->first();
            $user->status = "1";
            $user->save();
            $token = JWTAuth::fromUser($user);
            $response = array();
            $response += ["error" => false];
            $response += ["message" => "Done"];
            $response += ["token" => $token];
            return response()->json($response, 200);
        }
        $response = array();
        $response += ["error" => true];
        $response += ["message" => "Error"];
        //$response += ["token" => $token];
        return response()->json($response, 200);
    }

    public function resetPassword(Request $request)
    {
        $phone = $request->json()->get("phone");
        if (self::isPhoneAlreadyRegistered($phone)) {
            $code = rand(100000, 999999);
            $validate = new ResetPassword();
            $validate->phone = $phone;
            $validate->code = $code;
            $validate->save();
            self::sendSMS($phone, $code);
            $response = array();
            $response += ["error" => false];
            $response += ["message" => "Code Have Been Sended to Your Phone"];
            //$response +=["code" => $code];
            return response()->json($response, 200);
        }
        $response = array();
        $response += ["error" => true];
        $response += ["message" => "No Number Match this phone"];
        return response()->json($response, 200);
    }

    public function resetPasswordWithCode(Request $request)
    {
        $phone = $request->json()->get("phone");
        $code = $request->json()->get("code");
        $password = $request->json()->get("password");
        if (!isset($phone)) {
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "Insert phone "];
            return response()->json($response, 200);
        }

        if (!isset($code)) {
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "Insert code "];
            return response()->json($response, 200);

        }
        if (!isset($password)) {
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "You Forget The New Password"];
            return response()->json($response, 200);

        }
        if (!self::isPhoneAlreadyRegistered($phone)) {
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "No Number Match this phone"];
            return response()->json($response, 200);
        }
        $validate = ResetPassword::where("phone", $phone)->where("code", $code)->get();
        if ($validate->isNotEmpty()) {
            $user = User::where("phone", $phone)->first();
            $user->password = Hash::make($password);
            $user->save();
            $response = array();
            $response += ["error" => false];
            $response += ["message" => "Password Have been Reset"];
            return response()->json($response, 200);
        }
    }


    public function payment(Request $request)
    {


        //return response()->json(compact( 'token','user'));
        if ($request->isJson()) {
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            //$user = JWTAuth::toUser($token);
            /******   Create Transaction Object  *********/
            $transaction = new Transaction();
            $transaction->user()->associate($user);
            $service = $request->json()->get("service");
            $service_id = $this->getServiceId($service);
            if ($service_id == null) {
                $res = array();
                $res += ["error" => true];
                $res += ["message" => "Service Name Not Found"];
                return response()->json($res, 200);
            }
            $type = TransactionType::where('name', "payment")->pluck('id')->first();
            $transaction->transactionType()->associate($type);
            $convert = $this->getDateTime();


            $uuid = Uuid::generate()->string;
            //$uuid=Uuid::randomBytes(16);

            $transaction->uuid = $uuid;
            $transaction->transDateTime = $convert;
            $transaction->status = "created";
            $transaction->save();


            /*****   Create Payment Object     ******/
            $payment = new Payment();
            $payment->transaction()->associate($transaction);

            $payment->service()->associate($service_id);
            $payment->accountType()->associate(2);
            $payment->save();

            $service = MerchantServices::where("id", $payment->service->id)->first();
            if ($service->type->name == "goverment") {
                $response = self::sendGovermentServiceRequest($transaction->id);
                $basicResonse = Response::saveBasicResponse($transaction, $response);
                $paymentResponse = PaymentResponse::savePaymentResponse($basicResonse, $payment, $response);
                GovermentPaymentResponse::saveGovermentResponse($paymentResponse, $response);
                $transaction->status = "done";
                $transaction->save();
                return response()->json($response, '200');

            } else if ($service->type->name == "private") {
                $response = self::sendPaymentRequest($transaction->id);
                $basicResonse = Response::saveBasicResponse($transaction, $response);
                $paymentResponse = PaymentResponse::savePaymentResponse($basicResonse, $payment, $response);
                $transaction->status = "done";
                $transaction->save();

                $response += ["status" => "done"];
                $response += ["transaction_id" => $transaction->uuid];
                return response()->json($response, '200');
            }
            $res = array();
            $res += ["status" => "done"];
            $res += ["transaction_id" => $transaction->uuid];
            return response()->json($res, '200');

        } else
            return response("Not Json", 415);
    }






    public function checkAccount($paymentType, $account)
    {
        if ($paymentType == "mobile") {
            if (isset($account["mobile"]) && isset($account["ipin"])) {
                return null;
            } else {
                return response()->json(
                    [
                        "error" => "There are some error",
                        "status" => "mobile account missing"
                    ]
                    , '200');
            }
        } else {
            if (isset($account["pan"]) && isset($account["ipin"]) && isset($account["expDate"]) && isset($account["mbr"])) {
                return null;
            } else {
                return response()->json(
                    [
                        "error" => "There are some error",
                        "status" => "bank account missing"
                    ]
                    , '200');
            }
        }
    }


    public function getServiceId($name)
    {
        return MerchantServices::where('name', $name)->first();
    }

    public function isUserAuthoraized($user, $transaction)
    {
        return Transaction::where("id", $transaction->id)->where("user_id", $user->id)->first();
    }

    public function isUsernameFound($username)
    {
        $user = User::where("username", $username)->get();
        return $user->isEmpty() ? false : true;
    }

    public static function isPhoneAlreadyRegistered($phone)
    {
        $user = User::where("phone", $phone)->get();
        return $user->isEmpty() ? false : true;
    }

    public static function sendSMS($phone, $code)
    {
        $service_url = 'http://sms.iprosolution-sd.com/app/gateway/gateway.php'; //'http://api.unifonic.com/rest/Messages/Send';
        $curl = curl_init($service_url);
        $curl_post_data = array(
            "sendmessage" => 1,
            "username" => 'Sadad',
            "password" => 'Sadad@123',
            "text" => ' رمز التحقق هو  ' . $code,
            "numbers" => $phone,
            "sender" => 'Properties',
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        $curl_response = curl_exec($curl);
        curl_close($curl);
    }


}
