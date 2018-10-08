<?php

namespace App\Http\Controllers\API;

use App\Model\Account\BankAccount;
use App\Model\ResetPassword;
use App\Model\User;
use App\Model\UserValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use App\Functions;

class AuthController extends Controller
{




    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(),[
                'phone' => 'required',
                'IPIN' => 'required',
            ]
        );
        if ($validator->fails()){
            return response()->json([
                'error' => true,
                'errors' => $validator->errors()->toArray()
            ]);
        }



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
            else{
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


            //return response()->json($request,200);

            $validator = Validator::make($request->all(),[
                'phone' => 'required|unique:users|numeric',
                'fullName' => 'required|string',

                'userName' => 'required|unique:users|string',
                'password' => 'required|string',
                'PAN' => 'required|numeric|digits_between:16,19|unique:bank_accounts',
                'IPIN' => 'required|numeric|digits_between:4,4',
                'expDate' => 'required|date',
            ]);

            if ($validator->fails()){
                return response()->json([
                    'error' => true,
                    'errors' => $validator->errors()->toArray()
                ]);
            }


            $user = $request->json();
            $fullName = $user->get("fullName");
            $userName = $user->get("userName");
            $phone = $user->get("phone");
            $password = $user->get("password");
            $PAN = $user->get("PAN");
            $IPIN = $user->get("IPIN");
            $expDate = $user->get("expDate");
            $mbr = "0";



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
        $validator = Validator::make($request->all(),[
                'phone' => 'required|numeric',
                'code' => 'required|numeric',
            ]
        );
        if ($validator->fails()){
            return response()->json([
                'error' => true,
                'errors' => $validator->errors()->toArray()
            ]);
        }



        $phone = $request->json()->get("phone");
        $code = $request->json()->get("code");


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
        $validator = Validator::make($request->all(),[
                'phone' => 'requierd|numeric',
            ]
        );
        if ($validator->fails()){
            return response()->json([
                'error' => true,
                'errors' => $validator->errors()->toArray()
            ]);
        }
        $phone = $request->json()->get("phone");
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

    public function resetPasswordWithCode(Request $request)
    {

        $validator = Validator::make($request->all(),[
                'phone' => 'requierd|numeric',
                'code' => 'requierd|numeric',
                'password' => 'requierd|string',
            ]
        );
        if ($validator->fails()){
            return response()->json([
                'error' => false,
                'errors' => $validator->errors()->toArray()
            ]);
        }


        $phone = $request->json()->get("phone");
        $code = $request->json()->get("code");
        $password = $request->json()->get("password");

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
        $response = array();
        $response += ["error" => true];
        $response += ["message" => "Error"];
        return response()->json($response, 200);
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
