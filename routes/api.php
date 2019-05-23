<?php

use Illuminate\Http\Request;

//Login Register logout
Route::post('/login', 'Auth\LoginController@login');
Route::middleware('auth:api')->post('/logout', 'Auth\LoginController@logout');
Route::post('/register', 'Auth\RegisterController@register');

//User Routes
Route::middleware('auth:api')->resource('/user','Api\UsersController');
Route::middleware('auth:api')->post('/user/posts/{id}','Api\UsersController@posts')->name('userPosts');

//Post Routes
Route::middleware('auth:api')->resource('/post','Api\PostsController');
Route::middleware('auth:api')->delete('/post/deleteImg/{id}','Api\PostsController@deleteImage')->name('deleteImage');
Route::middleware('auth:api')->get('/post/{id}/comments','Api\PostsController@getComments')->name('postComments');

//Comment Routes
Route::middleware('auth:api')->get('/comment', 'Api\CommentController@sendMessage');
Route::middleware('auth:api')->get('/comment', 'Api\CommentController@sendMessage');
Route::middleware('auth:api')->get('/comment/send-email','Api\CommentController@sendEmail');

//Admin Routes
Route::group(['namespace' => 'Api\Admin','prefix' => 'admin','middleware' => 'auth:api'],function (){
    Route::get('/users',['uses'=>'AdminController@getUsers','as' => 'adminUsers']);
});
