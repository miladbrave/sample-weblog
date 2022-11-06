<?php

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

Route::group(['prefix' => 'auth'],function (){
    Route::post('login', 'App\Http\Controllers\ApiV1\Authenticate\LoginController');
    Route::post('register', 'App\Http\Controllers\ApiV1\Authenticate\RegisterController');
});

Route::group(['prefix' => 'post'],function (){
    Route::get('/', 'App\Http\Controllers\ApiV1\Post\indexController');
    Route::post('/create', 'App\Http\Controllers\ApiV1\Authenticate\RegisterController');
    Route::get('/edit/{slug}', 'App\Http\Controllers\ApiV1\Authenticate\RegisterController');
    Route::put('/update/}', 'App\Http\Controllers\ApiV1\Authenticate\RegisterController');
});
