<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'],function (){
    Route::post('login', 'Authenticate\LoginController');
    Route::post('register', 'Authenticate\RegisterController');
});

Route::group(['prefix' => 'posts','middleware' => 'auth:sanctum'],function (){
    Route::get('/', 'Post\indexController');
    Route::post('/create-post', 'Post\CreatePostController');
    Route::put('/edit-post', 'Post\EditPostController');
});

Route::post('/to-change-role', 'Teacher\ChangeRoleController');
