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

// Home route
Route::get('/', 'HomeController@index');

// Event routes
Route::get('/create-event', 'EventController@createEvent');

// Category routes
Route::get('/categories', 'CategoryController@all');
Route::get('/categories/{id}', 'CategoryController@single');

// User routes
Route::get('/user', 'UserController@index');
Route::get('/user/{id}', 'UserController@other');

// Auth Routes (Front-end)
Route::get('/login', 'AuthController@login');
Route::get('/register', 'AuthController@register');

// API Auth routes
Route::group(['prefix' => 'api/auth'], function () {
	Route::post('signup', 'AuthController@signup');
	Route::post('signin', 'AuthController@signin');
	Route::post('signout', 'AuthController@signout');
	Route::get('check', 'AuthController@isAuthenticated');
});

// API routes
Route::group(['prefix' => 'api/v1'], function () {
	Route::get('/users/{username}/events', 'UserController@events');
	Route::resource('users', 'UserController', ['only' => [
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
