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


Route::post("register" , "API\AuthController@registration")->middleware('cors');
Route::post("activate" , "API\AuthController@activate");
Route::post("login" , "API\AuthController@authenticate");
Route::post("requestreset" , "API\AuthController@resetPassword");
Route::post("resetpassword" , "API\AuthController@resetPasswordWithCode");
//Route::post('payment' , 'ApiController@payment')->middleware('jwt.auth');
//Route::post('payment_account' , 'ApiController@payment_account')->middleware('jwt.auth');
Route::post('topUp' , 'API\TopUp@topUp')->middleware('jwt.auth');
Route::post('balance_inquiry' , 'API\BalanceInquiry@balance_inquiry')->middleware('jwt.auth');
Route::post('cardTransfer' , 'API\CardTransfer@card_transfer')->middleware('jwt.auth');
Route::post('electricity' , 'API\Electricity@electricity')->middleware('jwt.auth');
Route::post('e15_payment','API\E15@e15_payment');
Route::post('e15_inquery','API\E15@e15_inquery');


Route::get('getByUsers', 'API\ElectHistoryApiController@getByUsers');
Route::get('getAllTransaction', 'API\HistoryApi@getAllTransactionsByUser');
Route::get('wallet', 'API\Wallet@balance_inquiry');