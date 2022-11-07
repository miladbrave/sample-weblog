<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'],function (){
    Route::post('login', 'Authenticate\LoginController');
    Route::post('register', 'Authenticate\RegisterController');
});

Route::group(['prefix' => 'posts','middleware' => 'auth:sanctum'],function (){
    Route::get('/', 'Post\indexController');
    Route::post('/create-post', 'Post\CreatePostController');
    Route::put('/edit-post/{slug}', 'Post\EditPostController');
    Route::delete('/delete/{id}', 'Post\DeletePostController');
    Route::delete('/remove-image/{id}', 'Post\DeletePostController');
});

Route::post('/to-change-role', 'General\ChangeRoleController');
