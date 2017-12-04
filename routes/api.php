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

Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function ()
{
    Route::post('/oauth/token', 'AccessTokenController@issueToken')->name("api::oauth::login");
    Route::post('/users', 'UserController@create');

    // Authorization required routes
    Route::group(['middleware' => ['api', 'auth:api']], function ($api)
    {
        Route::patch('oauth/token', 'AccessTokenController@revokeToken')->name("api::oauth::logout");
        Route::get('users/me', 'UserController@me');
        Route::get('users/{id}', 'UserController@get');
        Route::patch('users/{id}', 'UserController@update');
    });
});
