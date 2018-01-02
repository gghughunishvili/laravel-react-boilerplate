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

        // Users
        Route::get('users/me', 'UserController@me');
        Route::get('users/{id}', 'UserController@get');
        Route::get('users', 'UserController@find');
        Route::delete('users/{id}', 'UserController@delete');
        Route::patch('users/{id}', 'UserController@update');

        // Roles
        Route::post('roles', 'RoleController@create');
        Route::get('roles', 'RoleController@find');
        Route::get('roles/{id}', 'RoleController@get');
        Route::delete('roles/{id}', 'RoleController@delete');
        Route::get('roles/{id}/permissions', 'RoleController@getPermissions');
        Route::post('roles/{roleId}/permissions/{permissionId}', 'RoleController@attachPermission');
        Route::delete('roles/{roleId}/permissions/{permissionId}', 'RoleController@detachPermission');

        // Permissions
        Route::get('permissions', 'PermissionController@find');
    });
});
