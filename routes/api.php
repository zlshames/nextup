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

Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'auth'], function () {
	Route::post('signup', 'AuthController@signup');
	Route::post('signin', 'AuthController@signin');
	Route::post('signout', 'AuthController@signout');
});

Route::group(['prefix' => 'v1'], function () {
	Route::resource('events', 'UserController', ['only' => [
		'show', 'update', 'destroy'
	]]);

	Route::resource('events', 'EventController', ['only' => [
		'store', 'show', 'update', 'destroy'
	]]);

	Route::resource('categories', 'CategoryController', ['only' => [
		'store', 'show', 'update', 'destroy'
	]]);
});
