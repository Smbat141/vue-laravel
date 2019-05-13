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
Route::post('/login', 'Auth\LoginController@login');
Route::middleware('auth:api')->post('/logout', 'Auth\LoginController@logout');
Route::post('/register', 'Auth\RegisterController@register');

Route::middleware('auth:api')->resource('/user','Api\UsersController');
Route::middleware('auth:api')->resource('/post','Api\PostsController');

//Auth::routes();
