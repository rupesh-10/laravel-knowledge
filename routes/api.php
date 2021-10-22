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

Route::post('login', 'Auth\LoginController@login');
Route::post('register','Auth\RegisterController@register')->middleware('verification')->name('register');
Route::post('confirmInvitation','Auth\RegisterController@confirmInvitation')->middleware('invitation')->name('confirm');



// Admin Routes
Route::group(['namespace'=> 'API', 'middleware'=>['auth:sanctum','admin']], function (){
    Route::group(['prefix' => 'admin'], function () {
        Route::post('invitation', 'AdminController@invite');
    });
});

// User Routes
Route::group(['namespace'=> 'API', 'middleware'=>['auth:sanctum']], function (){
    Route::group(['prefix' => 'user'], function () {
        Route::post('updateProfile/{id}', 'UserController@updateProfile')->name('updateProfile');
    });
});


