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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::get('login', 'Auth\LoginController@login');

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('logout', 'Auth\LoginController@logout');
        Route::get('refresh', 'Auth\LoginController@refresh');
        Route::get('me', 'Auth\LoginController@me');
    });
});