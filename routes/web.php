<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'api/auth'], function () {
	Route::post('signup', 'AuthController@signup');
	Route::post('signin', 'AuthController@signin');
	Route::post('signout', 'AuthController@signout');
	Route::get('check', 'AuthController@isAuthenticated');
});

Route::group(['prefix' => 'api/v1'], function () {
	Route::resource('events', 'UserController', ['only' => [
		'show', 'update', 'destroy'
	]]);

	Route::resource('events', 'EventController', ['only' => [
		'store', 'show', 'showByDate', 'update', 'destroy'
	]]);

	Route::resource('categories', 'CategoryController', ['only' => [
		'store', 'show', 'update', 'destroy'
	]]);

	Route:: resource('notifications', 'NotificationController', ['only' => [
		'store', 'show', 'update', 'destroy'
	]]);
});
