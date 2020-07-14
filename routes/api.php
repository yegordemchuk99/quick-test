<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('login', 'AuthController@login');
Route::post('sign-up', 'AuthController@signUp');

Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');

        Route::get('users', 'UserController@index');

        Route::get('inviters', 'InviteController@index');

        Route::post('invite', 'InviteController@invite');
        Route::post('accept-invite', 'InviteController@accept');
        Route::post('decline-invite', 'InviteController@decline');

        Route::get('friends', 'FriendController@index');
});