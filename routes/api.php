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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', 'Api\Auth\AuthController@login');
    Route::post('/register','Api\Auth\RegisterController@register');
    Route::post('password/email', 'Api\Auth\ForgotPasswordController@sendResetLinkEmail');

});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'Api\Auth\AuthController@logout')->name('logout.api');
});

Route::group(['middleware' => ['cors', 'auth:api','json.response']], function(){
    Route::get('queris', 'Api\QureyController@getQuries');
    Route::post('queris-store', 'Api\QureyController@storeQuries');
    Route::post('query-response', 'Api\QureyController@responseQurey');

    });