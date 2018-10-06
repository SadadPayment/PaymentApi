<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::group('/api/pay')
Route::post("register" , "API\AuthController@registration")->middleware('cors');
Route::post("activate" , "API\ApiController@activate");
Route::post("login" , "API\ApiController@authenticate");
Route::post("requestreset" , "API\ApiController@resetPassword");
Route::post("resetpassword" , "API\ApiController@resetPasswordWithCode");
//Route::post('payment' , 'ApiController@payment')->middleware('jwt.auth');
//Route::post('payment_account' , 'ApiController@payment_account')->middleware('jwt.auth');
Route::post('topUp' , 'API\TopUp@topUp')->middleware('jwt.auth');
Route::post('balance_inquiry' , 'API\BalanceInquiry@balance_inquiry')->middleware('jwt.auth');
Route::post('cardTransfer' , 'API\CardTransfer@card_transfer')->middleware('jwt.auth');
Route::post('electricity' , 'API\Electricity@electricity')->middleware('jwt.auth');
Route::post('e15','API\E15@e15')->middleware('jwt.auth');


