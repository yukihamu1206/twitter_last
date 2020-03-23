<?php


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


Route::post('post_tweet','ApiController@postTweet')->middleware('auth:api');
Route::post('favorite','ApiController@favorite');
Route::delete('favorite/{favorite}','ApiController@deleteFavorite');
