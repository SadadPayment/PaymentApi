<?php

namespace App\Http\Controllers\API;

use App\Model\Account\BankAccount;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller
{


    public function authenticate(Request $request)
    {


        $request->validate([
           'phone' => 'requierd',
            'IPIN' => 'required',
        ]);


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
            $request->validate([
                'phone' => 'requierd|unique:users|number',
                'fullName' => 'requierd|string',

                'username' => 'required|unique:users|string',
                'password' => 'required|string',
                'PAN' => 'required|number|unique:bank_accounts',
                'IPIN' => 'required|number',
                'expDate' => 'required|date',
            ]);
            return response()->json($request,200);


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

}
