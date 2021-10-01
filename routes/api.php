<?php

use Illuminate\Http\Request;
use App\Http\Controllers\DetailOrdersController;

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

Route::get('/customers', 'CustomersController@show'); 
Route::get('/customers/{id}', 'CustomersController@detail');
Route::post('/customers', 'CustomersController@store'); 
Route::put('/customers/{id}', 'CustomersController@update');
Route::delete('/customers/{id}', 'CustomersController@destroy');

Route::get('/product', 'ProductController@show'); 
Route::get('/product/{id}', 'ProductController@detail');
Route::post('/product', 'ProductController@store');
Route::put('/product/{id}', 'ProductController@update');
Route::delete('/product/{id}', 'ProductController@destroy');

Route::get('/officer', 'OfficerController@show'); 
Route::get('/officer/{id}', 'OfficerController@detail');
Route::post('/officer', 'OfficerController@store');
Route::put('/officer/{id}', 'OfficerController@update');
Route::delete('/officer/{id}', 'OfficerController@destroy');

Route::get('/order', 'OrderController@show');
Route::get('/order/{id}', 'OrderController@detail');
Route::post('/order', 'OrderController@store');
Route::put('/order/{id}', 'OrderController@update');
Route::delete('/order/{id}', 'OrderController@destroy');

Route::get('/detailOrders', 'DetailOrdersController@show');
Route::get('detailOrders/{id}', 'DetailOrdersController@detail');
Route::post('/detailOrders', 'DetailOrdersController@store');
Route::put('/detailOrders/{id}', 'DetailOrdersController@update');
Route::delete('/detailOrders/{id}', 'DetailOrdersController@destroy');