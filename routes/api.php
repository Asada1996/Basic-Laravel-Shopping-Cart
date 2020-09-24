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

Route::get('/sneakers', 'SneakersController@list');
Route::post('/sneakers', 'SneakersController@create');
Route::get('/sneakers/{sneaker}', 'SneakersController@get');
Route::put('/sneakers/{sneaker}', 'SneakersController@update');
Route::delete('/sneakers/{sneaker}', 'SneakersController@delete');
Route::post('/sneakers/{sneaker}/rating', 'SneakersController@rate');
