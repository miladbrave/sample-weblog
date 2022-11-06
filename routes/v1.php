<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'],function (){
    Route::post('login', 'Authenticate\RegisterController');
    Route::post('register', 'Authenticate\RegisterController');
});

Route::group(['prefix' => 'post'],function (){
    Route::get('/', 'Post\indexController');
    Route::post('/create', 'App\Http\Controllers\ApiV1\Authenticate\RegisterController');
    Route::get('/edit/{slug}', 'App\Http\Controllers\ApiV1\Authenticate\RegisterController');
    Route::put('/update/}', 'App\Http\Controllers\ApiV1\Authenticate\RegisterController');
});
