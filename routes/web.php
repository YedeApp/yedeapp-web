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

// Home
Route::get('/', 'HomeController@index')->name('home');

// Authentication Routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('smscode', 'Auth\RegisterController@getSmsCode')->name('smscode');

// Password Reset Routes
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Course Routes
Route::resource('course', 'CourseController', ['only' => ['show', 'create', 'store', 'update', 'edit']]);
Route::get('course/{course}/chapters', 'CourseController@chapters')->name('course.chapters');
Route::get('course/{course}/purchase', 'CourseController@purchase')->name('course.purchase');
Route::get('course/purchase/push', 'CourseController@push')->name('course.push');
Route::get('course/purchase/pull', 'CourseController@pull')->name('course.pull');

// Topic Routes
Route::resource('topic', 'TopicController', ['only' => ['create', 'edit', 'store', 'update', 'destroy']]);
Route::get('course/{course}/topic/{topic}/{slug?}', 'TopicController@show')->name('topic.show');

// Comment Routes
Route::resource('comment', 'CommentController', ['only' => ['store', 'destroy']]);

// User Routes
Route::resource('user', 'UserController', ['only' => ['update', 'edit']]);
Route::get('user/{user}/password', 'UserController@showResetPasswordForm')->name('user.password');
Route::post('user/{user}/password', 'UserController@resetPassword')->name('user.reset');
Route::get('user/{user}/{tab?}', 'UserController@show')->name('user.show');
Route::post('user/{user}/upload', 'UserController@uploadAvatar')->name('user.upload');