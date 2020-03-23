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


Route::post('post_tweet','ApiController@post_tweet')->middleware('auth:api');
Route::get('get_user','ApiController@get_user');
Route::post('favorite','ApiController@favorite');
Route::delete('favorite/{favorite}','ApiController@delete_favorite');
Route::put('update_tweet/{tweet}','ApiController@update_tweet')->middleware('auth:api');
Route::delete('delete_tweet/{tweet}','ApiController@delete_tweet')->middleware('auth:api');
