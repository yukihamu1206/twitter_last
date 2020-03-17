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
Route::get('get_timeline',"ApiController@get_timeline");
Route::post('favorite','ApiController@favorite');
Route::delete('favorite/{favorite}','ApiController@delete_favorite');
