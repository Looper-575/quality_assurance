<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(\App\Http\Middleware\ValidateApi::class)->group(function () {
    Route::get('/call_connect', 'App\Http\Controllers\ApiController@call_connect')->name('call_connect_api');
    //Route::post('/call_connect', 'App\Http\Controllers\ApiController@call_connect')->name('call_connect_api');
    Route::get('/call_end', 'App\Http\Controllers\ApiController@call_end')->name('call_end_api');
    //Route::post('/call_end', 'App\Http\Controllers\ApiController@call_end')->name('call_end_api');
});
