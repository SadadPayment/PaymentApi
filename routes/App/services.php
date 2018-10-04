<?php
/******************************
Service Controller
 *////////////////////////////

Route::get('/services' , 'ServiceController@index');//Show All Services
Route::get('/services/create' , 'ServiceController@create');//Show Service Insert Form
Route::post('/services' , 'ServiceController@store');//Save New Service
Route::get('/services/{id}/edit' , 'ServiceController@edit');//Show Service Edit Form
Route::post('/services/{id}/update' , 'ServiceController@update');//Save Update Service

Route::get('/services/{id}/delete', 'ServiceController@delete');//Delete Service


/******************************
End Service Controller
 *////////////////////////////

