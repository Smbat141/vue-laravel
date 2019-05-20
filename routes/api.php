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
Route::middleware('auth:api')->post('/user/posts/{id}','Api\UsersController@posts')->name('userPosts');
Route::middleware('auth:api')->resource('/post','Api\PostsController');
Route::middleware('auth:api')->delete('/post/deleteImg/{id}','Api\PostsController@deleteImage')->name('deleteImage');
Route::middleware('auth:api')->get('/post/{id}/comments','Api\PostsController@getComments')->name('postComments');

Route::middleware('auth:api')->get('/comment', 'Api\CommentController@sendMessage');

//Auth::routes();
