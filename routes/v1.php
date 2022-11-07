<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'],function (){
    Route::post('login', 'Authenticate\LoginController');
    Route::post('register', 'Authenticate\RegisterController');
});

Route::group(['prefix' => 'posts','middleware' => 'auth:sanctum'],function (){
    Route::get('/', 'Post\indexController');
    Route::post('/create-post', 'Post\CreatePostController');
    Route::get('/edit-post/{slug}', 'App\Http\Controllers\ApiV1\Authenticate\RegisterController');
    Route::put('/update/}', 'App\Http\Controllers\ApiV1\Authenticate\RegisterController');
});
