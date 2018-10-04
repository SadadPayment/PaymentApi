<?php
/******************************
Merchant Controller
*////////////////////////////

Route::get('/merchants' , 'MerchantController@index');//Show All Merchants
Route::get('/merchants/create' , 'MerchantController@create');//Show Merchant Insert Form
Route::post('/merchants' , 'MerchantController@store');//Save New Merchant
Route::get('/merchants/{id}/edit' , 'MerchantController@edit');//Show Merchant Edit Form
Route::post('/merchants/{id}/update' , 'MerchantController@update');//Save Update Merchant

Route::get('/merchants/{id}/delete', 'MerchantController@delete');//Delete Merchant


/******************************
End Merchant Controller
*////////////////////////////