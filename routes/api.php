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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user()->getRoleNames();
// });

Route::group(['middleware' => ['cors',]], function () {
    Route::post('/login', 'Api\Auth\AuthController@login')->name('login');
    Route::get('/profile', 'Api\Auth\AuthController@profile');
    Route::post('password/email', 'Api\Auth\ForgotPasswordController@sendResetLinkEmail');

});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'Api\Auth\AuthController@logout')->name('logout.api');
});

Route::group(['middleware' => ['cors', 'auth:api',]], function(){
    Route::post('/register','Api\Auth\RegisterController@register');
    Route::get('queris', 'Api\QureyController@getQuries');
    Route::post('queris-store', 'Api\QureyController@storeQuries');
    Route::post('query-response', 'Api\QureyController@responseQurey');
    Route::post('create-role', 'Api\PermissionController@createRole');
    Route::get('category', 'Api\CategoryController@getCategory');
    Route::post('category-store', 'Api\CategoryController@storeCategory');
    Route::post('category-update', 'Api\CategoryController@updateCategory');
    Route::post('category-delete', 'Api\CategoryController@deleteCategory');

    Route::get('page', 'Api\PageController@getPages');
    Route::post('page-store', 'Api\PageController@pageStore');
    });