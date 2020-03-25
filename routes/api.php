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



Route::post('tweet','ApiController@store')->middleware('auth:api');
Route::put('tweet/{tweet}','ApiController@update')->middleware('auth:api');
Route::delete('tweet/{tweet}','ApiController@destroy')->middleware('auth:api');
Route::post('favorite','ApiController@favorite');
Route::delete('favorite/{favorite}','ApiController@deleteFavorite');
Route::put('user/{user}','ApiController@userUpdate')->middleware('auth:api');
