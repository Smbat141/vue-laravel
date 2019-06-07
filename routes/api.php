<?php

use Illuminate\Http\Request;

//Login Register logout
Route::post('/login', 'Auth\LoginController@login');
Route::middleware('auth:api')->post('/logout', 'Auth\LoginController@logout');
Route::post('/register', 'Auth\RegisterController@register');

//User Routes
Route::middleware('auth:api')->resource('/user','Api\UsersController');
Route::middleware('auth:api')->post('/user/posts/{id}','Api\UsersController@posts')->name('userPosts');
Route::middleware('auth:api')->get('/user-subscriptions','Api\UsersController@UserSubscriptions')->name('userSubscriptions');

//Post Routes
Route::middleware(['auth:api'])->resource('/post','Api\PostsController');
Route::middleware('auth:api')->delete('/post/deleteImg/{id}','Api\PostsController@deleteImage')->name('deleteImage');
Route::middleware('auth:api')->get('/post/{id}/comments','Api\PostsController@getComments')->name('postComments');

//Comment Routes
Route::middleware('auth:api','payment:api')->get('/comment', 'Api\CommentController@sendMessage');
Route::middleware('auth:api')->get('/comment', 'Api\CommentController@sendMessage');
Route::middleware('auth:api')->get('/comment/send-email','Api\CommentController@sendEmail');

//Admin Routes
Route::group(['namespace' => 'Api\Admin','prefix' => 'admin','middleware' => 'auth:api'],function (){
    Route::get('/users',['uses'=>'AdminController@getUsers','as' => 'adminUsers']);
});
//Payment Routes
Route::middleware('auth:api')->post('/new-card', 'Api\PaymentController@UserCard');
Route::middleware('auth:api')->post('/subscribe', 'Api\PaymentController@Subscribe');
Route::middleware('auth:api')->post('/change-plan', 'Api\PaymentController@ChangePlan');
Route::middleware('auth:api')->post('/cancel-subscription', 'Api\PaymentController@CancelSubscription');
Route::middleware('auth:api')->post('/create-post', 'Api\PaymentController@CreatePost');
Route::post('braintree/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');






