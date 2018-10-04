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
Route::post("register" , "ApiController@registration")->middleware('cors');
Route::post("activate" , "ApiController@activate");
Route::post("login" , "ApiController@authenticate");
Route::post("requestreset" , "ApiController@resetPassword");
Route::post("resetpassword" , "ApiController@resetPasswordWithCode");
//Route::post('payment' , 'ApiController@payment')->middleware('jwt.auth');
//Route::post('payment_account' , 'ApiController@payment_account')->middleware('jwt.auth');
Route::post('topUp' , 'TopUp@topUp')->middleware('jwt.auth');
Route::post('balance_inquiry' , 'BalanceInquiry@balance_inquiry')->middleware('jwt.auth');
Route::post('cardTransfer' , 'CardTransfer@card_transfer')->middleware('jwt.auth');
Route::post('electricity' , 'Electricity@electricity')->middleware('jwt.auth');
Route::post('e15','E15@e15')->middleware('jwt.auth');


